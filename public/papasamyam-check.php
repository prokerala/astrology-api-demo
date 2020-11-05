<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Profile;
use Prokerala\Api\Astrology\Service\PapaSamyamCheck;
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
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$sample_name = 'papasamyam-check';

if (isset($_POST['submit'])) {
    $girl_datetime = $_POST['girl_dob'];
    $girl_timezone = $_POST['girl_timezone'] ?? '';
    $girl_coordinates = $_POST['girl_coordinates'];
    $girl_coordinates_data = explode(',', $girl_coordinates);

    $boy_datetime = $_POST['boy_dob'];
    $boy_timezone = $_POST['boy_timezone'] ?? '';
    $boy_coordinates = $_POST['boy_coordinates'];
    $boy_coordinates_data = explode(',', $boy_coordinates);

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
        $porutham = new PapaSamyamCheck($client);
        $porutham->setAyanamsa($ayanamsa);
        $result = $porutham->process($girl_profile, $boy_profile);
        $message = $result->getMessage();
        $papaSamyamCheckResult['message'] = [
            'type' => $message->getType(),
            'description' => $message->getDescription(),
        ];

        $girlPapasamyam = $result->getGirlPapasamyam();
        $boyPapasamyam = $result->getBoyPapasamyam();

        $papaSamyamCheckResult['girlPapasamyam']['total_point'] = $girlPapasamyam->getTotalPoints();
        $papaSamyam = $girlPapasamyam->getPapaSamyam();
        $papaPlanets = $papaSamyam->getPapaPlanet();
        foreach ($papaPlanets as $idx => $papaPlanet) {
            $papaSamyamCheckResult['girlPapasamyam']['papaPlanet'][$idx]['name'] = $papaPlanet->getName();
            $planetDoshas = $papaPlanet->getPlanetDosha();
            foreach ($planetDoshas as $planetDosha) {
                $papaSamyamCheckResult['girlPapasamyam']['papaPlanet'][$idx]['planetDosha'][] = [
                    'id' => $planetDosha->getId(),
                    'name' => $planetDosha->getName(),
                    'position' => $planetDosha->getPosition(),
                    'hasDosha' => $planetDosha->hasDosha(),
                ];
            }
        }

        $papaSamyamCheckResult['boyPapasamyam']['total_point'] = $boyPapasamyam->getTotalPoints();
        $papaSamyam = $boyPapasamyam->getPapaSamyam();
        $papaPlanets = $papaSamyam->getPapaPlanet();
        foreach ($papaPlanets as $idx => $papaPlanet) {
            $papaSamyamCheckResult['boyPapasamyam']['papaPlanet'][$idx]['name'] = $papaPlanet->getName();
            $planetDoshas = $papaPlanet->getPlanetDosha();
            foreach ($planetDoshas as $planetDosha) {
                $papaSamyamCheckResult['boyPapasamyam']['papaPlanet'][$idx]['planetDosha'][] = [
                    'id' => $planetDosha->getId(),
                    'name' => $planetDosha->getName(),
                    'position' => $planetDosha->getPosition(),
                    'hasDosha' => $planetDosha->hasDosha(),
                ];
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
include DEMO_BASE_DIR . '/templates/papasamyam-check.tpl.php';
