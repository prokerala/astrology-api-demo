<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\VimsottariDasha;
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
$result_type = 'basic';
$ayanamsa = 1;
$sample_name = 'kundli';
$la = $_POST['la'] ?? 'en';
$timezone = 'Asia/Kolkata';
if (isset($_POST['submit'])) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $ayanamsa = $_POST['ayanamsa'];
    $result_type = $_POST['result_type'];
    $timezone = $_POST['timezone'] ?? '';
}

$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);

$location = new Location((float)$input['latitude'], (float)$input['longitude'], 0, $tz);

$result = [];
$errors = [];

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
    'ta' => 'Tamil',
    'te' => 'Telugu',
    'ml' => 'Malayalam',
];

if ($submit) {
    try {

        $method = new VimsottariDasha($client);
        $method->setAyanamsa($ayanamsa);
        $method->setTimeZone($tz);
        $result = $method->process($location, $datetime, $la);

        $dashaPeriods = $result->getDashaPeriods();
        $dashaPeriodResult = [];
        foreach ($dashaPeriods as $dashaPeriod) {
            $antardashas = $dashaPeriod->getAntardasha();
            $antardashaResult = [];
            foreach ($antardashas as $antardasha) {
                $pratyantardashas = $antardasha->getPratyantardasha();
                $pratyantardashaResult = [];
                foreach ($pratyantardashas as $pratyantardasha) {
                    $pratyantardashaResult[] = [
                        'id' => $pratyantardasha->getId(),
                        'name' => $pratyantardasha->getName(),
                        'start' => $pratyantardasha->getStart(),
                        'end' => $pratyantardasha->getEnd(),
                    ];
                }
                $antardashaResult[] = [
                    'id' => $antardasha->getId(),
                    'name' => $antardasha->getName(),
                    'start' => $antardasha->getStart(),
                    'end' => $antardasha->getEnd(),
                    'pratyantardasha' => $pratyantardashaResult,
                ];
            }
            $dashaPeriodResult[] = [
                'id' => $dashaPeriod->getId(),
                'name' => $dashaPeriod->getName(),
                'start' => $dashaPeriod->getStart(),
                'end' => $dashaPeriod->getEnd(),
                'antardasha' => $antardashaResult,
            ];
        }
        $kundliResult['dashaPeriods'] = $dashaPeriodResult;

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

include DEMO_BASE_DIR . '/templates/dasha-periods.tpl.php';
