<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Western\Service\Charts\SynastryChart;
use Prokerala\Api\Astrology\Western\Service\AspectCharts\SynastryChart as SynastryAspectChart;
use Prokerala\Api\Astrology\Western\Service\PlanetPositions\SynastryChart as SynastryPlanetAspects;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$sample_name = 'synastry-chart';

$primary_latitude = 19.0821978;
$primary_longitude = 72.7411014;
$secondary_latitude = 35.6895;
$secondary_longitude = 139.692;

$primaryCoordinates = "{$primary_latitude},{$primary_longitude}"; // Mumbai
$secondaryCoordinates = "{$secondary_latitude},{$secondary_longitude}"; // Tokyo

$primaryDatetime = (new DateTimeImmutable("1989-10-25", new DateTimeZone('Asia/Kolkata')))->format('c');
$secondaryDatetime = (new DateTimeImmutable("1994-01-18", new DateTimeZone('Asia/Tokyo')))->format('c');

$houseSystem = 'placidus';
$orb = 'default';
$primaryBirthTimeUnknown = 'false';
$secondaryBirthTimeUnknown = 'false';
$rectificationChart = 'flat-chart';
$aspectFilter = 'major';
$chartType = 'zodiac-contact-chart';

$submit = $_POST['submit'] ?? 0;

if (isset($_POST['submit'])) {
    $primaryDatetime = $_POST['partner_a_dob'];
    $primaryCoordinates = $_POST['partner_a_coordinates'];
    $primaryBirthTimeUnknown = $_POST['partner_a_birth_time_unknown'] ?? false;
    $arCoordinates = explode(',', $primaryCoordinates);
    $primary_latitude = $arCoordinates[0] ?? '';
    $primary_longitude = $arCoordinates[1] ?? '';

    $secondaryDatetime = $_POST['partner_b_dob'];
    $secondaryBirthTimeUnknown = $_POST['partner_b_birth_time_unknown'] ?? false;
    $secondaryCoordinates = $_POST['partner_b_coordinates'];
    $arCoordinates = explode(',', $secondaryCoordinates);
    $secondary_latitude = $arCoordinates[0] ?? '';
    $secondary_longitude = $arCoordinates[1] ?? '';

    $houseSystem = $_POST['house_system'];
    $orb = $_POST['orb'];
    $rectificationChart = $_POST['birth_time_rectification'];
    $aspectFilter = $_POST['aspect_filter'];
    $chartType = $_POST['chart_type'];
}

$primaryBirthLocation = new Location((float)$primary_latitude, (float)$primary_longitude, 0);
$secondaryBirthLocation = new Location((float)$secondary_latitude, (float)$secondary_longitude, 0);

$primaryBirthTime = new DateTimeImmutable($primaryDatetime, $primaryBirthLocation->getTimeZone());
$secondaryBirthTime = new DateTimeImmutable($secondaryDatetime, $secondaryBirthLocation->getTimeZone());

$result = [];
$errors = [];

if ($submit) {
    try {
        $method = new SynastryChart($client);

        $chart = $method->process(
            $primaryBirthLocation,
            $primaryBirthTime,
            $secondaryBirthLocation,
            $secondaryBirthTime,
            $houseSystem,
            $chartType,
            $orb,
            $primaryBirthTimeUnknown === 'true',
            $secondaryBirthTimeUnknown === 'true',
            $rectificationChart,
            $aspectFilter
        );

        $method = new SynastryAspectChart($client);

        $aspectChart = $method->process(
            $primaryBirthLocation,
            $primaryBirthTime,
            $secondaryBirthLocation,
            $secondaryBirthTime,
            $houseSystem,
            $chartType,
            $orb,
            $primaryBirthTimeUnknown === 'true',
            $secondaryBirthTimeUnknown === 'true',
            $rectificationChart,
            $aspectFilter
        );

        $method = new SynastryPlanetAspects($client);

        $result = $method->process(
            $primaryBirthLocation,
            $primaryBirthTime,
            $secondaryBirthLocation,
            $secondaryBirthTime,
            $houseSystem,
            $chartType,
            $orb,
            $primaryBirthTimeUnknown === 'true',
            $secondaryBirthTimeUnknown === 'true',
            $rectificationChart,
        );
        $aspects = $result->getAspects();

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

include DEMO_BASE_DIR . '/templates/synastry-chart.tpl.php';
