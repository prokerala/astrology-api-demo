<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\Chart;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$time_now = new DateTimeImmutable();

$arChartType = [
    'rasi', 'navamsa', 'lagna', 'trimsamsa', 'drekkana', 'chaturthamsa',
    'dasamsa', 'ashtamsa', 'dwadasamsa', 'shodasamsa', 'hora', 'akshavedamsa',
    'shashtyamsa', 'panchamsa', 'khavedamsa', 'saptavimsamsa', 'shashtamsa',
    'chaturvimsamsa', 'saptamsa', 'vimsamsa',
];

$input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '19.0821978',
    'longitude' => '72.7411014', // Mumbai
];
$chart_type = 'rasi';
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$chart_style = 'south-indian';
$sample_name = 'chart';

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
    'ta' => 'Tamil',
    'te' => 'Telugu',
    'ml' => 'Malayalam',
];

$timezone = 'Asia/Kolkata';
if ($submit) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $chart_type = $_POST['chart_type'];
    $chart_style = $_POST['chart_style'];
    $timezone = $_POST['timezone'] ?? '';
    $la = $_POST['la'] ?? 'en';
}

$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);

$location = new Location((float)$input['latitude'], (float)$input['longitude'], 0, $tz);

$result = [];
$errors = [];

if ($submit) {
    try {
        $method = new Chart($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime, $chart_type, $chart_style, $la);
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

include DEMO_BASE_DIR . '/templates/chart.tpl.php';
