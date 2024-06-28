<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\ChandrashtamaPeriod;
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
    'year' => 2022,
];
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$submit = $_POST['submit'] ?? 0;
$la = $_POST['la'] ?? 'en';
$ayanamsa = 1;
$sample_name = 'birth-details';

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
    'ta' => 'Tamil',
    'ml' => 'Malayalam',
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
$year = $input['year'];
$location = new Location((float)$input['latitude'], (float)$input['longitude'], 0, $tz);

$result = [];
$errors = [];

if ($submit) {
    try {
        $method = new ChandrashtamaPeriod($client);
        $method->setAyanamsa($ayanamsa);
        $method->setTimeZone($tz);

        $result = $method->process($location, $datetime, (int)$year, $la);
        $rasi = $result->getChandrashtama()->getRasi();
        $nakshatraList = implode(', ', array_map(static fn ($nakshatra) => $nakshatra->getName(), $result->getChandrashtama()->getNakshatra()));
        $timings = $result->getChandrashtamaTiming();
        $nakshatraDetails = [];
        foreach ($timings as $timing) {
            foreach ($timing->getNakshatraTimings() as $nakshatraTiming) {
                $name = $nakshatraTiming->getNakshatra()->getName();
                $nakshatraDetails[$name][] = [
                    'start' => $nakshatraTiming->getStart(),
                    'end' => $nakshatraTiming->getEnd(),
                    'isPeak' => $nakshatraTiming->isPeak(),
                ];
            }
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

include DEMO_BASE_DIR . '/templates/chandrashtama-periods.tpl.php';
