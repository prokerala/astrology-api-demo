<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Western\Service\Charts\NatalChart;
use Prokerala\Api\Astrology\Western\Service\AspectCharts\NatalChart as NatalAspectChart;
use Prokerala\Api\Astrology\Western\Service\PlanetPositions\NatalChart as NatalPlanetPosition;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$sample_name = 'natal-chart';

$datetime = (new DateTimeImmutable('now', new DateTimeZone('Asia/Kolkata')))->format('c');

$latitude = 19.0821978;
$longitude = 72.7411014;
$coordinates = "{$latitude},{$longitude}"; // Mumbai

$submit = $_POST['submit'] ?? 0;

$houseSystem = 'placidus';
$orb = 'default';
$birthTimeUnknown = false;
$rectificationChart = 'flat-chart';
$aspectFilter = 'major';
$timezone = 'Asia/Kolkata';

if (isset($_POST['submit'])) {
    $datetime = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $latitude = $arCoordinates[0] ?? '';
    $longitude = $arCoordinates[1] ?? '';
    $houseSystem = $_POST['house_system'];
    $orb = $_POST['orb'];
    $birthTimeUnknown = isset($_POST['birth_time_unknown']);
    $rectificationChart = $_POST['birth_time_rectification'];
    $aspectFilter = $_POST['aspect_filter'];
    $timezone = $_POST['timezone'] ?? '';
    $la = $_POST['la'] ?? 'en';
}
$tz = new DateTimeZone($timezone);

$location = new Location((float)$latitude, (float)$longitude, 0, $tz);

$datetime = new DateTimeImmutable($datetime, $location->getTimeZone());

$result = [];
$errors = [];

$apiCreditUsed = 0;

if ($submit) {
    try {
        $method = new NatalChart($client);
        $chart = $method->process($location, $datetime, $houseSystem, $orb, $birthTimeUnknown, $rectificationChart, $aspectFilter, $la);
        $apiCreditUsed += $client->getCreditUsed();

        $method = new NatalAspectChart($client);
        $aspectChart = $method->process($location, $datetime, $houseSystem, $orb, $birthTimeUnknown, $rectificationChart, $aspectFilter, $la);
        $apiCreditUsed += $client->getCreditUsed();

        $method = new NatalPlanetPosition($client);
        $result = $method->process($location, $datetime, $houseSystem, $orb, $birthTimeUnknown, $rectificationChart, $la);
        $planetPositions = $result->getPlanetPositions();
        $houses = $result->getHouses();
        $angles = $result->getAngles();
        $aspects = $result->getAspects();
        $declinations = $result->getDeclinations();
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

include DEMO_BASE_DIR . '/templates/natal-chart.tpl.php';
