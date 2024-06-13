<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Western\Service\AspectCharts\TransitChart as TransitAspectChart;
use Prokerala\Api\Astrology\Western\Service\Charts\TransitChart;
use Prokerala\Api\Astrology\Western\Service\PlanetPositions\TransitChart as TransitPlanetPositions;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$sample_name = 'transit-chart';

$transitDatetime = new DateTimeImmutable('now', new DateTimeZone('Asia/Kolkata'));
$birthTime = $transitDatetime->modify('-18 years')->format('c');
$transitDatetime = $transitDatetime->format('c');

$latitude = 19.0821978; // Mumbai
$longitude = 72.7411014;
$current_latitude = 19.0821978; // Mumbai
$current_longitude = 72.7411014;

$submit = $_POST['submit'] ?? 0;

$houseSystem = 'placidus';
$orb = 'default';
$birthTimeUnknown = 'false';
$rectificationChart = 'flat-chart';
$aspectFilter = 'major';
$timezone = 'Asia/Kolkata';
$current_timezone = 'Asia/Kolkata';
$la = 'en';

if (isset($_POST['submit'])) {
    $birthTime = $_POST['datetime'];
    $transitDatetime = $_POST['transit_datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $latitude = $arCoordinates[0] ?? '';
    $longitude = $arCoordinates[1] ?? '';
    $transitCoordinates = $_POST['current_coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $current_latitude = $arCoordinates[0] ?? '';
    $current_longitude = $arCoordinates[1] ?? '';
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

$location = new Location((float)$latitude, (float)$longitude, 0, $tz);
$transitLocation = new Location((float)$current_latitude, (float)$current_longitude, 0, $currentTimezone);

$datetime = new DateTimeImmutable($birthTime, $location->getTimeZone());
$transitDatetime = new DateTimeImmutable($transitDatetime, $location->getTimeZone());

$result = [];
$errors = [];

$apiCreditUsed = 0;

if ($submit) {
    try {
        $method = new TransitChart($client);
        $chart = $method->process(
            $location,
            $datetime,
            $transitLocation,
            $transitDatetime,
            $houseSystem,
            $orb,
            $birthTimeUnknown,
            $rectificationChart,
            $aspectFilter,
            $la,
        );
        $apiCreditUsed += $client->getCreditUsed();

        $method = new TransitAspectChart($client);
        $aspectChart = $method->process(
            $location,
            $datetime,
            $transitLocation,
            $transitDatetime,
            $houseSystem,
            $orb,
            $birthTimeUnknown,
            $rectificationChart,
            $aspectFilter,
            $la,
        );
        $apiCreditUsed += $client->getCreditUsed();

        $method = new TransitPlanetPositions($client);

        $result = $method->process(
            $location,
            $datetime,
            $transitLocation,
            $transitDatetime,
            $houseSystem,
            $orb,
            $birthTimeUnknown,
            $rectificationChart,
            $la,
        );

        $details = $result->getTransitDetails();
        $transitNatalAspects = $result->getTransitNatalAspect();
        $transitDatetime = $result->getTransitDatetime();
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

include DEMO_BASE_DIR . '/templates/transit-chart.tpl.php';
