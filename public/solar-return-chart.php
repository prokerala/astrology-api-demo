<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Western\Service\AspectCharts\SolarReturnChart as SolarReturnAspectChart;
use Prokerala\Api\Astrology\Western\Service\Charts\SolarReturnChart;
use Prokerala\Api\Astrology\Western\Service\PlanetPositions\SolarReturnChart as SolarReturnPlanetPositions;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$sample_name = 'solar-return-chart';
$time_now = new DateTimeImmutable();

$input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '19.0821978',
    'longitude' => '72.7411014', // Mumbai
    'transit_latitude' => '19.0821978',
    'transit_longitude' => '72.7411014', // Mumbai
];
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$transitCoordinates = $input['transit_latitude'] . ',' . $input['transit_longitude'];
$solarYear = (int)$time_now->format('Y') + 1;
$submit = $_POST['submit'] ?? 0;
$houseSystem = 'placidus';
$orb = 'default';
$birthTimeUnknown = false;
$rectificationChart = 'flat-chart';
$aspectFilter = 'major';

$timezone = 'Asia/Kolkata';
$current_timezone = 'Asia/Kolkata';
$la = 'en';

if (isset($_POST['submit'])) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $transitCoordinates = $_POST['current_coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $arCoordinates = explode(',', $transitCoordinates);
    $input['transit_latitude'] = $arCoordinates[0] ?? '';
    $input['transit_longitude'] = $arCoordinates[1] ?? '';
    $solarYear = (int)$_POST['solar_return_year'];
    $houseSystem = $_POST['house_system'];
    $orb = $_POST['orb'];
    $birthTimeUnknown = isset($_POST['birth_time_unknown']);
    $rectificationChart = $_POST['birth_time_rectification'];
    $aspectFilter = $_POST['aspect_filter'];

    $timezone = $_POST['timezone'] ?? '';
    $current_timezone = $_POST['current_timezone'] ?? '';
    $la = $_POST['la'] ?? 'en';
}

$tz = new DateTimeZone($timezone);
$currentTimezone = new DateTimeZone($current_timezone);

$location = new Location((float)$input['latitude'], (float)$input['longitude'], 0, $tz);
$datetime = new DateTimeImmutable($input['datetime'], $location->getTimeZone());
$transitLocation = new Location((float)$input['transit_latitude'], (float)$input['transit_longitude'], 0, $currentTimezone);

$result = [];
$errors = [];

$apiCreditUsed = 0;

if ($submit) {
    try {
        $method = new SolarReturnChart($client);
        $chart = $method->process(
            $location,
            $datetime,
            $transitLocation,
            $solarYear,
            $houseSystem,
            $orb,
            $birthTimeUnknown,
            $rectificationChart,
            $aspectFilter,
            $la
        );
        $apiCreditUsed += $client->getCreditUsed();

        $method = new SolarReturnAspectChart($client);
        $aspectChart = $method->process(
            $location,
            $datetime,
            $transitLocation,
            $solarYear,
            $houseSystem,
            $orb,
            $birthTimeUnknown,
            $rectificationChart,
            $aspectFilter,
            $la
        );
        $apiCreditUsed += $client->getCreditUsed();

        $method = new SolarReturnPlanetPositions($client);
        $result = $method->process(
            $location,
            $datetime,
            $transitLocation,
            $solarYear,
            $houseSystem,
            $orb,
            $birthTimeUnknown,
            $rectificationChart,
            $la
        );

        $details = $result->getSolarDetails();
        $solarNatalAspects = $result->getSolarNatalAspect();
        $solarDatetime = $result->getSolarDatetime();
        $houses = $details->getHouses();
        $planetPositions = $details->getPlanetPositions();
        $angles = $details->getAngles();
        $aspects = $details->getAspects();
        $declinations = $details->getDeclinations();
        $apiCreditUsed += $client->getCreditUsed();
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

include DEMO_BASE_DIR . '/templates/solar-return-chart.tpl.php';
