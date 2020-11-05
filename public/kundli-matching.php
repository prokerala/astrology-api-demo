<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Profile;
use Prokerala\Api\Astrology\Service\KundliMatching;
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

$girl_timezone = $boy_timezone = 'Asia/Kolkata';

$girl_coordinates = $girl_input['latitude'] . ',' . $girl_input['longitude'];
$boy_coordinates = $boy_input['latitude'] . ',' . $boy_input['longitude'];
$result_type = 'basic';
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$sample_name = 'kundli-matching';

if ($submit) {
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
        $ayanamsa = $_POST['ayanamsa'];
    }
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
        $advanced = false;
        if ('advanced' === $result_type) {
            $advanced = true;
        }
        $kundli_matching = new KundliMatching($client);
        $kundli_matching->setAyanamsa($ayanamsa);
        $result = $kundli_matching->process($girl_profile, $boy_profile, $advanced);

        $girl_info = $result->getGirlInfo();
        $boy_info = $result->getBoyInfo();
        $boy_koot = $boy_info->getKoot();
        $girl_koot = $girl_info->getKoot();

        $girl_nakshatra = $girl_info->getNakshatra();
        $boy_nakshatra = $boy_info->getNakshatra();
        $girl_nakshatra_lord = $girl_nakshatra->getLord();
        $boy_nakshatra_lord = $boy_nakshatra->getLord();

        $girl_rasi = $girl_info->getRasi();
        $boy_rasi = $boy_info->getRasi();
        $girl_rasi_lord = $girl_rasi->getLord();
        $boy_rasi_lord = $boy_rasi->getLord();

        $compatibilityResult['boyInfo']['koot'] = $boy_koot->getKoot();
        $compatibilityResult['girlInfo']['koot'] = $girl_koot->getKoot();


        $compatibilityResult['girlInfo']['nakshatra'] = [
            'id' => $girl_nakshatra->getId(),
            'name' => $girl_nakshatra->getName(),
            'pada' => $girl_nakshatra->getPada(),
            'lord' => [
                'id' => $girl_nakshatra_lord->getId(),
                'name' => $girl_nakshatra_lord->getName(),
                'vedicName' => $girl_nakshatra_lord->getVedicName()
            ],
        ];

        $compatibilityResult['boyInfo']['nakshatra'] = [
            'id' => $boy_nakshatra->getId(),
            'name' => $boy_nakshatra->getName(),
            'pada' => $boy_nakshatra->getPada(),
            'lord' => [
                'id' => $boy_nakshatra_lord->getId(),
                'name' => $boy_nakshatra_lord->getName(),
                'vedicName' => $boy_nakshatra_lord->getVedicName()
            ],
        ];

        $compatibilityResult['girlInfo']['rasi'] = [
            'id' => $girl_rasi->getId(),
            'name' => $girl_rasi->getName(),
            'lord' => [
                'id' => $girl_rasi_lord->getId(),
                'name' => $girl_rasi_lord->getName(),
                'vedicName' => $girl_rasi_lord->getVedicName()
            ],
        ];

        $compatibilityResult['boyInfo']['rasi'] = [
            'id' => $boy_rasi->getId(),
            'name' => $boy_rasi->getName(),
            'lord' => [
                'id' => $boy_rasi_lord->getId(),
                'name' => $boy_rasi_lord->getName(),
                'vedicName' => $boy_rasi_lord->getVedicName()
            ],
        ];

        $message = $result->getMessage();
        $compatibilityResult['message'] = [
            'type' => $message->getType(),
            'description' => $message->getDescription(),
        ];

        $gunaMilan = $result->getGunaMilan();
        $compatibilityResult['gunaMilan'] = [
            'totalPoints' => $gunaMilan->getTotalPoints(),
            'maximumPoints' => $gunaMilan->getMaximumPoints(),
        ];



        if ($advanced) {
            $arGuna = $gunaMilan->getGuna();

            foreach ($arGuna as $guna) {
                $compatibilityResult['gunaMilan']['guna'][] = [
                    'id' => $guna->getId(),
                    'name' => $guna->getName(),
                    'girlKoot' => $guna->getGirlKoot(),
                    'boyKoot' => $guna->getBoyKoot(),
                    'maximumPoints' => $guna->getMaximumPoints(),
                    'obtainedPoints' => $guna->getObtainedPoints(),
                    'description' => $guna->getDescription(),
                ];
            }
            $compatibilityResult['exceptions'] = $result->getExceptions();

            $girl_mangal_dosha_details = $result->getGirlMangalDoshaDetails();
            $boy_mangal_dosha_details = $result->getBoyMangalDoshaDetails();

            $compatibilityResult['girlMangalDoshaDetails'] = [
                'hasMangalDosha' => $girl_mangal_dosha_details->hasDosha(),
                'hasException' => $girl_mangal_dosha_details->hasException(),
                'mangalDoshaType' => $girl_mangal_dosha_details->getDoshaType(),
                'description' => $girl_mangal_dosha_details->getDescription(),
            ];

            $compatibilityResult['boyMangalDoshaDetails'] = [
                'hasMangalDosha' => $boy_mangal_dosha_details->hasDosha(),
                'hasException' => $boy_mangal_dosha_details->hasException(),
                'mangalDoshaType' => $boy_mangal_dosha_details->getDoshaType(),
                'description' => $boy_mangal_dosha_details->getDescription(),
            ];
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
include DEMO_BASE_DIR . '/templates/kundli-matching.tpl.php';
