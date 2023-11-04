<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Western\Service\AspectCharts\SynastryChart;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$sample_name = 'synastry-aspect-chart';
$time_a = new DateTimeImmutable("1989-10-25");
$time_b = new DateTimeImmutable("1994-01-18");

$input = [
    'primary_datetime' => $time_a->format('c'),
    'secondary_datetime' => $time_b->format('c'),
    'primary_latitude' => '19.0821978',
    'primary_longitude' => '72.7411014', // Mumbai
    'secondary_latitude' => '35.6895',
    'secondary_longitude' => '139.692', // Tokyo
];
$primaryCoordinates = $input['primary_latitude'] . ',' . $input['primary_longitude'];
$secondaryCoordinates = $input['secondary_latitude'] . ',' . $input['secondary_longitude'];
$submit = $_POST['submit'] ?? 0;
$houseSystem = 'placidus';
$orb = 'default';
$primaryBirthTimeUnknown = 'false';
$secondaryBirthTimeUnknown = 'false';
$rectificationChart = 'noon';
$timezone = 'Asia/Kolkata';
$aspectFilter = 'all';
$chartType = 'zodiac-contact-chart';

if (isset($_POST['submit'])) {
    $input['primary_datetime'] = $_POST['partner_a_dob'];
    $input['secondary_datetime'] = $_POST['partner_b_dob'];
    $primaryCoordinates = $_POST['partner_a_coordinates'];
    $secondaryCoordinates = $_POST['partner_b_coordinates'];
    $arCoordinates = explode(',', $primaryCoordinates);
    $input['primary_latitude'] = $arCoordinates[0] ?? '';
    $input['primary_longitude'] = $arCoordinates[1] ?? '';
    $arCoordinates = explode(',', $secondaryCoordinates);
    $input['secondary_latitude'] = $arCoordinates[0] ?? '';
    $input['secondary_longitude'] = $arCoordinates[1] ?? '';
    $houseSystem = $_POST['house_system'];
    $orb = $_POST['orb'];
    $primaryBirthTimeUnknown = $_POST['partner_a_birth_time_unknown'];
    $secondaryBirthTimeUnknown = $_POST['partner_b_birth_time_unknown'];
    $rectificationChart = $_POST['birth_time_rectification'];
    $aspectFilter = $_POST['aspect_filter'];
    $chartType = $_POST['chart_type'];
}

$primaryBirthLocation = new Location((float)$input['primary_latitude'], (float)$input['primary_longitude'], 0);
$secondaryBirthLocation = new Location((float)$input['secondary_latitude'], (float)$input['secondary_longitude'], 0);

$primaryBirthTime = new DateTimeImmutable($input['primary_datetime'], $primaryBirthLocation->getTimeZone());
$secondaryBirthTime = new DateTimeImmutable($input['secondary_datetime'], $secondaryBirthLocation->getTimeZone());

$result = [];
$errors = [];

if ($submit) {
    try {
        $method = new SynastryChart($client);

        $result = $method->process(
            $primaryBirthLocation,
            $primaryBirthTime,
            $secondaryBirthLocation,
            $secondaryBirthTime,
            $houseSystem,
            $chartType,
            $orb,
            $primaryBirthTimeUnknown,
            $secondaryBirthTimeUnknown,
            $rectificationChart,
            $aspectFilter
        );
        $chart = $result->getChart();

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

include DEMO_BASE_DIR . '/templates/synastry-aspect-chart.tpl.php';
