<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$time_now = new DateTimeImmutable();

$input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '19.0821978',
    'longitude' => '72.7411014', // Mumbai
];
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$result_type = 'basic';
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$sample_name = 'mangal-dosha';

$timezone = 'Asia/Kolkata';
if (isset($_POST['submit'])) {
    $input['datetime'] = $_POST['datetime'];
    $result_type = $_POST['result_type'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $ayanamsa = $_POST['ayanamsa'];
    $timezone = $_POST['timezone'] ?? '';
}

$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);

$location = new Location($input['latitude'], $input['longitude'], 0, $tz);


$result = [];
$errors = [];

if ($submit) {
    try {
        $advanced = 'advanced' === $result_type;

        $method = new \Prokerala\Api\Astrology\Service\MangalDosha($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime, $advanced);

        $mangal_dosha_result = [];

        $mangal_dosha_result['has_mangal_dosha'] = $result->hasDosha();
        $mangal_dosha_result['description'] = $result->getDescription();

        if ($advanced) {
            $mangal_dosha_result['has_exception'] = $result->hasException();
            $mangal_dosha_result['mangal_dosha_type'] = $result->getType();

            $mangal_dosha_result['exceptions'] = $result->getExceptions();
            $mangal_dosha_result['remedies'] = $result->getRemedies();
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
include DEMO_BASE_DIR . '/templates/mangal-dosha.tpl.php';
