<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Western\Service\Charts\CompositeChart;
use Prokerala\Api\Astrology\Western\Service\AspectCharts\CompositeChart as CompositeAspectChart;
use Prokerala\Api\Astrology\Western\Service\PlanetPositions\CompositeChart as CompositePlanetPositions;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$sample_name = 'composite-chart';

$primary_latitude = 19.0821978;
$primary_longitude = 72.7411014;
$secondary_latitude = 35.6895;
$secondary_longitude = 139.692;
$current_latitude = 28.6;
$current_longitude = 77.2;

$primaryCoordinates = "{$primary_latitude},{$primary_longitude}"; // Mumbai
$secondaryCoordinates = "{$secondary_latitude},{$secondary_longitude}"; // Tokyo
$currentCoordinates = "{$current_latitude},{$current_longitude}"; // New Delhi

$primaryDatetime = (new DateTimeImmutable("1989-10-25", new DateTimeZone('Asia/Kolkata')))->format('c');
$secondaryDatetime = (new DateTimeImmutable("1994-01-18", new DateTimeZone('Asia/Tokyo')))->format('c');
$transitDateTime = (new DateTimeImmutable("now", new DateTimeZone('Asia/Kolkata')))->format('c');

$houseSystem = 'placidus';
$orb = 'default';
$primaryBirthTimeUnknown = false;
$secondaryBirthTimeUnknown = false;
$rectificationChart = 'flat-chart';
$aspectFilter = 'major';

$submit = $_POST['submit'] ?? 0;
$partner_a_timezone = 'Asia/Kolkata';
$partner_b_timezone = 'Asia/Kolkata';

if (isset($_POST['submit'])) {
    $primaryDatetime = $_POST['partner_a_dob'];
    $primaryCoordinates = $_POST['partner_a_coordinates'];
    $primaryBirthTimeUnknown = isset($_POST['partner_a_birth_time_unknown']);
    $arCoordinates = explode(',', $primaryCoordinates);
    $primary_latitude = $arCoordinates[0] ?? '';
    $primary_longitude = $arCoordinates[1] ?? '';

    $secondaryDatetime = $_POST['partner_b_dob'];
    $secondaryBirthTimeUnknown = isset($_POST['partner_b_birth_time_unknown']);
    $secondaryCoordinates = $_POST['partner_b_coordinates'];
    $arCoordinates = explode(',', $secondaryCoordinates);
    $secondary_latitude = $arCoordinates[0] ?? '';
    $secondary_longitude = $arCoordinates[1] ?? '';

    $transitDateTime = $_POST['transit_datetime'];
    $currentCoordinates = $_POST['current_coordinates'];
    $arCoordinates = explode(',', $primaryCoordinates);
    $current_latitude = $arCoordinates[0] ?? '';
    $current_longitude = $arCoordinates[1] ?? '';

    $houseSystem = $_POST['house_system'];
    $orb = $_POST['orb'];
    $rectificationChart = $_POST['birth_time_rectification'];
    $aspectFilter = $_POST['aspect_filter'];
    $partner_a_timezone = $_POST['partner_a_timezone'] ?? '';
    $partner_b_timezone = $_POST['partner_b_timezone'] ?? '';
}

$partner_a_timezone = new DateTimeZone($partner_a_timezone);
$partner_b_timezone = new DateTimeZone($partner_b_timezone);

$primaryBirthLocation = new Location((float)$primary_latitude, (float)$primary_longitude, 0, $partner_a_timezone);
$secondaryBirthLocation = new Location((float)$secondary_latitude, (float)$secondary_longitude, 0, $partner_b_timezone);
$currentLocation = new Location((float)$current_latitude, (float)$current_longitude, 0);

$primaryBirthTime = new DateTimeImmutable($primaryDatetime, $primaryBirthLocation->getTimeZone());
$secondaryBirthTime = new DateTimeImmutable($secondaryDatetime, $secondaryBirthLocation->getTimeZone());
$transitDateTime = new DateTimeImmutable($transitDateTime, $currentLocation->getTimeZone());

$result = [];
$errors = [];

$apiCreditUsed = 0;

if ($submit) {
    try {
        $method = new CompositeChart($client);

        $chart = $method->process(
            $primaryBirthLocation,
            $primaryBirthTime,
            $secondaryBirthLocation,
            $secondaryBirthTime,
            $currentLocation,
            $transitDateTime,
            $houseSystem,
            $orb,
            $primaryBirthTimeUnknown,
            $secondaryBirthTimeUnknown,
            $rectificationChart,
            $aspectFilter
        );
        $apiCreditUsed += $client->getCreditUsed();

        $method = new CompositeAspectChart($client);

        $aspectChart = $method->process(
            $primaryBirthLocation,
            $primaryBirthTime,
            $secondaryBirthLocation,
            $secondaryBirthTime,
            $currentLocation,
            $transitDateTime,
            $houseSystem,
            $orb,
            $primaryBirthTimeUnknown,
            $secondaryBirthTimeUnknown,
            $rectificationChart,
            $aspectFilter
        );
        $apiCreditUsed += $client->getCreditUsed();

        $method = new CompositePlanetPositions($client);

        $result = $method->process(
            $primaryBirthLocation,
            $primaryBirthTime,
            $secondaryBirthLocation,
            $secondaryBirthTime,
            $currentLocation,
            $transitDateTime,
            $houseSystem,
            $orb,
            $primaryBirthTimeUnknown,
            $secondaryBirthTimeUnknown,
            $rectificationChart,
        );
        $houses = $result->getCompositeHouses();
        $planetPositions = $result->getCompositePlanetPositions();
        $angles = $result->getCompositeAngles();
        $aspects = $result->getCompositeAspects();
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

include DEMO_BASE_DIR . '/templates/composite-chart.tpl.php';
