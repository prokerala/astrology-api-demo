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
    'tamil' => [
        'en' => 'English',
        'ta' => 'Tamil',
    ],
    'shaka-samvat' => [
        'en' => 'English',
        'ta' => 'Tamil',
        'hi' => 'Hindi',
        'te' => 'Telugu',
        'ml' => 'Malayalam',
    ],
    'vikram-samvat' => [
        'en' => 'English',
        'ta' => 'Tamil',
        'hi' => 'Hindi',
        'te' => 'Telugu',
        'ml' => 'Malayalam',
    ],
    'amanta' =>  [
        'en' => 'English',
        'ta' => 'Tamil',
        'hi' => 'Hindi',
        'te' => 'Telugu',
        'ml' => 'Malayalam',
    ],
    'purnimanta' =>  [
        'en' => 'English',
        'ta' => 'Tamil',
        'hi' => 'Hindi',
        'te' => 'Telugu',
        'ml' => 'Malayalam',
    ],
    'malayalam' => [
        'en' => 'English',
        'ml' => 'Malayalam',
    ],
    'hijri' => [
        'en' => 'English',
    ],
    'gujarati' =>  [
        'en' => 'English',
        'gu' => 'Gujarati',
    ],
    'bengali' =>  [
        'en' => 'English',
        'bn' => 'Bengali',
    ],
    'lunar' =>  [
        'en' => 'English',
        'ta' => 'Tamil',
        'hi' => 'Hindi',
        'te' => 'Telugu',
        'ml' => 'Malayalam',
    ],
];

$timezone = 'Asia/Kolkata';
if ($submit) {
    $input['date'] = $_POST['date'];
    $input['calendar'] = $_POST['calendar'];
    $la = $_POST['la'] ?? 'en';
    $calendar = $input['calendar'];
    $date = new DateTimeImmutable($input['date']);
}

$supportedLanguages = $arSupportedLanguages[$input['calendar'] ?? 'tamil'];
$result = [];
$errors = [];
$arData = [];

$today = new \DateTimeImmutable('now');
$weekNumber = (int)$today->format("W");
$dateMinimum = (new \DateTimeImmutable())->setISODate((int)$today->format('Y'), $weekNumber);
$dateMinimum = $dateMinimum->modify('-1 day');
$dateMaximum = $dateMinimum->modify('+6 days');

if ($submit) {
    try {
        if ($date < $dateMinimum || $date > $dateMaximum) {
            throw new Exception('Enter date between '. $dateMinimum->format('Y-m-d') .' and '. $dateMaximum->format('Y-m-d'));
        }
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
