<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Profile;
use Prokerala\Api\Astrology\Service\Porutham;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;

require __DIR__ . '/../vendor/autoload.php';

$client = include __DIR__ . '/../client.php';

$girl_input = [
    'datetime' => '1992-08-29T09:00:00+05:30',
    'latitude' => '19.0821978',
    'longitude' => '72.7411014',
];

$boy_input = [
    'datetime' => '1989-03-14T10:50:00+05:30',
    'latitude' => '8.0864019',
    'longitude' => '77.5371157',
];

$girl_coordinates = $girl_input['latitude'] . ',' . $girl_input['longitude'];
$boy_coordinates = $boy_input['latitude'] . ',' . $boy_input['longitude'];
$result_type = 'basic';
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$system = 'kerala';

if (isset($_POST['submit'])) {
    $girl_datetime = $_POST['girl_dob'];
    $boy_datetime = $_POST['boy_dob'];
    $girl_coordinates = $_POST['girl_coordinates'];
    $girl_coordinates_data = explode(',', $girl_coordinates);
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

$girl_location = new Location($girl_input['latitude'], $girl_input['longitude']);
$girl_dob = new DateTimeImmutable($girl_input['datetime']);
$girl_profile = new Profile($girl_location, $girl_dob);

$boy_location = new Location($boy_input['latitude'], $boy_input['longitude']);
$boy_dob = new DateTimeImmutable($boy_input['datetime']);
$boy_profile = new Profile($boy_location, $boy_dob);



$result = [];
$errors = [];

if($submit){
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

        $compatibilityResult['girlInfo'] = [
            'nakshatra' => [
                'id' => $girl_nakshatra->getId(),
                'Nakshatra' => $girl_nakshatra->getName(),
                'Nakshatra Pada' => $girl_nakshatra->getPada(),
                'Nakshatra Lord' => $girl_nakshatra->getLord(),
            ],
            'rasi' => [
                'id' => $girl_rasi->getId(),
                'Rasi' => $girl_rasi->getName(),
                'Rasi Lord' => $girl_rasi->getLord(),
            ],
        ];

        $compatibilityResult['boyInfo'] = [
            'nakshatra' => [
                'id' => $boy_nakshatra->getId(),
                'Nakshatra' => $boy_nakshatra->getName(),
                'Nakshatra Pada' => $boy_nakshatra->getPada(),
                'Nakshatra Lord' => $boy_nakshatra->getLord(),
            ],
            'rasi' => [
                'id' => $boy_rasi->getId(),
                'Rasi' => $boy_rasi->getName(),
                'Rasi Lord' => $boy_rasi->getLord(),
            ],
        ];

        $compatibilityResult['maximumPoint'] = $result->getMaximumPoints();
        $compatibilityResult['totalPoint'] = $result->getTotalPoints();
        $compatibilityResult['status'] = $result->getStatus();
        $compatibilityResult['description'] = $result->getDescription();

        foreach ($result->getMatches() as $idx => $match) {
            $compatibilityResult['Matches'][$idx] = [
                'id' => $match->getId(),
                'name' => $match->getName(),
                'hasPorutham' => $match->hasPorutham(),
            ];
            if ($advanced){
                $compatibilityResult['Matches'][$idx]['poruthamStatus'] = $match->getPoruthamStatus();
                $compatibilityResult['Matches'][$idx]['points'] = $match->getPoints();
                $compatibilityResult['Matches'][$idx]['description'] = $match->getDescription();
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
    } catch (Exception $e){
        $errors = ['message' => "API Request Failed with error {$e->getMessage()}"];
    }
}

include __DIR__ . '/../templates/porutham.tpl.php';
