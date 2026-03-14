<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\RajaYoga;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/datelimiter.php';

$time_now = new DateTimeImmutable();

$input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '19.0821978',
    'longitude' => '72.7411014', // Mumbai
];
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$submit = $_POST['submit'] ?? 0;
$la = $_POST['la'] ?? 'en';
$ayanamsa = 1;
$sample_name = 'raja-yoga';

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
    'ta' => 'Tamil',
    'ml' => 'Malayalam',
];

$categoryKey =  [
    1 => 'raja',
    2 => 'nabhasa',
    3 => 'solar',
    4 => 'lunar',
    5 => 'career',
    6 => 'conjunction',
    7 => 'health',
    8 => 'wealth',
    9 => 'progeny',
    10 => 'penury',
    11 => 'marriage',
    12 => 'specialraja',
    13 => 'major',
    14 => 'parivartana',
    15 => 'dainya',
    16 => 'khala',
    17 => 'maha',
    18 => 'akriti',
    19 => 'asraya',
    20 => 'dala',
    21 => 'sankhya',
    22 => 'arishta',
    23 => 'other',
];

$influenceKey = [
    1 => 'Wealth',
    2 => 'Finance',
    3 => 'Marriage',
    4 => 'Love',
    5 => 'Education',
    6 => 'Mother',
    7 => 'Family',
    8 => 'Appearance',
    9 => 'Personality',
    10 => 'Health',
    11 => 'Intelligence',
    12 => 'Career',
    13 => 'Courage'
];



$timezone = 'Asia/Kolkata';
if (isset($_POST['submit'])) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $ayanamsa = $_POST['ayanamsa'];
    $timezone = $_POST['timezone'] ?? '';
}

$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);

$location = new Location((float)$input['latitude'], (float)$input['longitude'], 0, $tz);

$result = [];
$yogaList = [];
$errors = [];

$yogaListInfluence = [];
$yogaListCategory = [];

if ($submit) {
    try {
        validateDateTime(
            $input['datetime'],
            $tz,
            new DateTimeImmutable('-1 day', $tz),
            new DateTimeImmutable('+1 day', $tz)
        );
        $method = new RajaYoga($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime, $la);
        foreach ($result->getYogaList() as $key => $yoga) {
            foreach ($yoga->getInfluence() as $influence) {
                $yogaListInfluence[$influence->getId()][] = $yoga;
            }
            foreach ($yoga->getCategory() as $category) {
                $yogaListCategory[$category->getId()][] = $yoga;
            }
        }


    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
        $errorsQuota = ['message' => '<p class="">The demo is currently disabled. You may request access to the demo by contacting our support team.</p><p class="">Please note that the demo page does <span class="b">not use credits from your account.</span> You can also download the full source code of this demo from the following link: <a href="https://github.com/prokerala/astrology-api-demo">https://github.com/prokerala/astrology-api-demo</a></p><div class=""><a href="https://api.prokerala.loc:8444/account/contact" class="btn btn-sm btn-info b">Request Demo</a></div>'];
    } catch (RateLimitExceededException $e) {
        $errors['message'] = 'ERROR: Rate limit exceeded. Throttle your requests.';
    } catch (AuthenticationException $e) {
        $errors = ['message' => $e->getMessage()];
    } catch (Exception $e) {
        if ($e->getMessage() === 'Your account does not have sufficient credit balance to execute this request.') {
            $errors = ['message' => 'Demo execution is currently unavailable. <a href="https://api.prokerala.loc:8444/account/contact">Click here to contact our customer care team.</a>'];
        } else {
            $errors = ['message' => "API Request Failed with error {$e->getMessage()}"];
        }
    }
}

$apiCreditUsed = $client->getCreditUsed();

include DEMO_BASE_DIR . '/templates/raja-yoga.tpl.php';
