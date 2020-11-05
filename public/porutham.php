<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Profile;
use Prokerala\Api\Astrology\Service\Porutham;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$time_now = new DateTimeImmutable();

$girl_input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '19.0821978',
    'longitude' => '72.7411014',
];

$boy_input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '8.0864019',
    'longitude' => '77.5371157',
];

$girl_coordinates = $girl_input['latitude'] . ',' . $girl_input['longitude'];
$boy_coordinates = $boy_input['latitude'] . ',' . $boy_input['longitude'];
$result_type = 'basic';
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$system = 'kerala';
$sample_name = 'porutham';

$girl_timezone = $boy_timezone = 'Asia/Kolkata';
if (isset($_POST['submit'])) {
    $girl_datetime = $_POST['girl_dob'];
    $girl_timezone = $_POST['girl_timezone'] ?? '';
    $girl_coordinates = $_POST['girl_coordinates'];
    $girl_coordinates_data = explode(',', $girl_coordinates);

    $boy_datetime = $_POST['boy_dob'];
    $boy_timezone = $_POST['boy_timezone'] ?? '';
    $boy_coordinates = $_POST['boy_coordinates'];
    $boy_coordinates_data = explode(',', $boy_coordinates);
    $result_type = $_POST['result_type'];
    $ayanamsa = $_POST['ayanamsa'];
    $system = $_POST['system'];

    $girl_input = [
        'datetime' => $girl_datetime,
        'latitude' => $girl_coordinates_data[0] ?? '',
        'longitude' => $girl_coordinates_data[1] ?? '',
    ];

    $boy_input = [
        'datetime' => $boy_datetime,
        'latitude' => $boy_coordinates_data[0] ?? '',
        'longitude' => $boy_coordinates_data[1] ?? '',
    ];
}

$girl_tz = new DateTimeZone($girl_timezone);

$girl_location = new Location($girl_input['latitude'], $girl_input['longitude'], 0, $girl_tz);

$girl_dob = new DateTimeImmutable($girl_input['datetime'], $girl_tz);
$girl_profile = new Profile($girl_location, $girl_dob);

$boy_tz = new DateTimeZone($boy_timezone);
$boy_location = new Location($boy_input['latitude'], $boy_input['longitude'], 0, $boy_tz);
$boy_dob = new DateTimeImmutable($boy_input['datetime'], $boy_tz);
$boy_profile = new Profile($boy_location, $boy_dob);

$result = [];
$errors = [];

if ($submit) {
    try {
        $advanced = 'advanced' === $result_type;
        $porutham = new Porutham($client);
        $porutham->setAyanamsa($ayanamsa);
        $result = $porutham->process($girl_profile, $boy_profile, $system, $advanced);

        $compatibilityResult = [];
        $girl_info = $result->getGirlInfo();
        $girl_nakshatra = $girl_info->getNakshatra();
        $girl_rasi = $girl_info->getRasi();

        $boy_info = $result->getBoyInfo();
        $boy_nakshatra = $boy_info->getNakshatra();
        $boy_rasi = $boy_info->getRasi();

        $girl_nakshatra_lord = $girl_nakshatra->getLord();
        $boy_nakshatra_lord = $boy_nakshatra->getLord();

        $girl_rasi_lord = $girl_rasi->getLord();
        $boy_rasi_lord = $boy_rasi->getLord();

        $compatibilityResult['girlInfo'] = [
            'nakshatra' => [
                'id' => $girl_nakshatra->getId(),
                'name' => $girl_nakshatra->getName(),
                'pada' => $girl_nakshatra->getPada(),
                'lord' => [
                    'id' => $girl_nakshatra_lord->getId(),
                    'name' => $girl_nakshatra_lord->getName(),
                    'vedicName' => $girl_nakshatra_lord->getVedicName()
                ],
            ],
            'rasi' => [
                'id' => $girl_rasi->getId(),
                'name' => $girl_rasi->getName(),
                'lord' => [
                    'id' => $girl_rasi_lord->getId(),
                    'name' => $girl_rasi_lord->getName(),
                    'vedicName' => $girl_rasi_lord->getVedicName()
                ],
            ],
        ];

        $compatibilityResult['boyInfo'] = [
            'nakshatra' => [
                'id' => $boy_nakshatra->getId(),
                'name' => $boy_nakshatra->getName(),
                'pada' => $boy_nakshatra->getPada(),
                'lord' => [
                    'id' => $boy_nakshatra_lord->getId(),
                    'name' => $boy_nakshatra_lord->getName(),
                    'vedicName' => $boy_nakshatra_lord->getVedicName()
                ],
            ],
            'rasi' => [
                'id' => $boy_rasi->getId(),
                'name' => $boy_rasi->getName(),
                'lord' => [
                    'id' => $boy_rasi_lord->getId(),
                    'name' => $boy_rasi_lord->getName(),
                    'vedicName' => $boy_rasi_lord->getVedicName()
                ],
            ],
        ];
        $compatibilityResult['maximumPoints'] = $result->getMaximumPoints();
        $compatibilityResult['totalPoints'] = $result->getTotalPoints();
        $message = $result->getMessage();
        $compatibilityResult['message'] = [
            'type' => $message->getType(),
            'description' => $message->getDescription(),
        ];

        $match_result = $result->getMatches();
        $matches = [];
        foreach ($match_result as $match) {
            $compatibilityResult['matches'][] = [
                'id' => $match->getId(),
                'name' => $match->getName(),
                'hasPorutham' => $match->hasPorutham(),
            ];
        }

        if ($advanced) {
            if ($advanced) {
                foreach ($match_result as $idx => $match) {
                    $compatibilityResult['matches'][$idx]['poruthamStatus'] = $match->getPoruthamStatus();
                    $compatibilityResult['matches'][$idx]['points'] = $match->getPoints();
                    $compatibilityResult['matches'][$idx]['description'] = $match->getDescription();
                }
            }
        }

    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
        $errors['message'] = 'ERROR: You have exceeded your quota allocation for the day';
    } catch (RateLimitExceededException $e) {
        $errors['message'] = 'ERROR: Rate limit exceeded. Throttle your requests.';
    } catch (AuthenticationException $e) {
        $errors = ['message' => $e->getMessage()];
    } catch (Exception $e) {
        $errors = ['message' => "API Request Failed with error {$e->getMessage()}"];
    }
}

$apiCreditUsed = $client->getCreditUsed();
include DEMO_BASE_DIR . '/templates/porutham.tpl.php';
