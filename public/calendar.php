<?php

declare(strict_types=1);

use Prokerala\Api\Calendar\Service\CalendarDate;
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
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$la = $_POST['la'] ?? 'en';
$sample_name = 'calendar';
$date = new DateTimeImmutable('now');

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
    'ta' => 'Tamil',
    'te' => 'Telugu',
    'ml' => 'Malayalam',
];

$timezone = 'Asia/Kolkata';
if ($submit) {
    $input['date'] = $_POST['date'];
    $input['calendar'] = $_POST['calendar'];
    $la = $_POST['la'] ?? 'en';
    $calendar = $input['calendar'];
    $date = new DateTimeImmutable($input['date']);
}

$result = [];
$errors = [];
$arData = [];

if ($submit) {
    try {
        $method = new CalendarDate($client);
        $result = $method->process($calendar, $date, $la);
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

include DEMO_BASE_DIR . '/templates/calendar.tpl.php';
