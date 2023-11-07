<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Western\Service\PlanetPositions\TransitChart;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$sample_name = 'transit-planet-position';

$transitDatetime = new DateTimeImmutable('now', new DateTimeZone('Asia/Kolkata'));
$birthTime = $transitDatetime->modify('-18 years')->format('c');
$transitDatetime = $transitDatetime->format('c');

$latitude = 19.0821978;// Mumbai
$longitude = 72.7411014;
$current_latitude = 19.0821978;// Mumbai
$current_longitude = 72.7411014;

$submit = $_POST['submit'] ?? 0;

$houseSystem = 'placidus';
$orb = 'default';
$birthTimeUnknown = 'false';
$rectificationChart = 'noon';
$aspectFilter = 'major';

if (isset($_POST['submit'])) {
    $datetime = $_POST['datetime'];
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
    $birthTimeUnknown = $_POST['birth_time_unknown'] ?? false;
    $rectificationChart = $_POST['birth_time_rectification'];
    $aspectFilter = $_POST['aspect_filter'];
}

$location = new Location((float)$latitude, (float)$longitude, 0);
$transitLocation = new Location((float)$current_latitude, (float)$current_longitude, 0);

$datetime = new DateTimeImmutable($birthTime, $location->getTimeZone());
$transitDatetime = new DateTimeImmutable($transitDatetime, $location->getTimeZone());

$result = [];
$errors = [];

if ($submit) {
    try {
        $method = new TransitChart($client);

        $result = $method->process($location, $datetime, $transitLocation, $transitDatetime,
                            $houseSystem, $orb, $birthTimeUnknown === 'true', $rectificationChart, $aspectFilter);

        $details =  $result->getTransitDetails();
        $transitNatalAspects  =  $result->getTransitNatalAspect();
        $transitDatetime =  $result->getTransitDatetime();
        $houses = $details->getHouses();
        $planetPositions = $details->getPlanetPositions();
        $angles = $details->getAngles();
        $aspects = $details->getAspects();
        $declinations = $details->getDeclinations();

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

include DEMO_BASE_DIR . '/templates/transit-planet-position.tpl.php';
