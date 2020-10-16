<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\Kundli;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/../vendor/autoload.php';

$client = include __DIR__ . '/../client.php';
$time_now = new DateTimeImmutable();
$input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '19.0821978',
    'longitude' => '72.7411014', // Mumbai
];
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;

if (isset($_POST['submit'])) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $ayanamsa = $_POST['ayanamsa'];
}

$datetime = new DateTimeImmutable($input['datetime']);
$tz = $datetime->getTimezone();

$location = new Location($input['latitude'], $input['longitude'], 0, $tz);

$result = [];
$errors = [];

if ($submit) {
    try {
        $method = new Kundli($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime);
        $nakshatraDetails = $result->getNakshatraDetails();
        $nakshatraResult = [
            'nakshatraName' => $nakshatraDetails->getNakshatraName(),
            'nakshatraLongitude' => $nakshatraDetails->getNakshatraLongitude(),
            'nakshatraStart' => $nakshatraDetails->getNakshatraStart(),
            'nakshatraEnd' => $nakshatraDetails->getNakshatraEnd(),
            'nakshatraPada' => $nakshatraDetails->getNakshatraPada(),
        ];

        foreach (['chandraRasi', 'sooryaRasi', 'zodiac'] as $item) {
            $fn = 'get' . ucwords($item);
            $itemResult = $nakshatraDetails->{$fn}();
            $nakshatraResult[$item] = [
                'id' => $itemResult->getId(),
                'name' => $itemResult->getName(),
                'longitude' => $itemResult->getLongitude(),
            ];
        }
        $additionalInfo = $nakshatraDetails->getAdditionalInfo();
        foreach (['diety', 'ganam', 'symbol', 'animalSign', 'nadi', 'color', 'bestDirection', 'syllables', 'birthStone', 'gender', 'planet', 'enemyYoni'] as $info) {
            $fn = 'get' . ucwords($info);
            $nakshatraResult['additionalInfo'][$info] = $additionalInfo->{$fn}();
        }

        $mangalDoshaResult = [];
        $mangalDoshaDetails = $result->getMangalDosha();
        $mangalDoshaResult['has_mangal_dosha'] = $mangalDoshaDetails->hasMangalDosha();
        $mangalDoshaResult['description'] = $mangalDoshaDetails->getDescription();

        $yogaDetails = $result->getYogas();
        $yogaResult = [];
        foreach (['majorYogas', 'chandrayogas', 'sooryaYogas', 'inauspiciousYogas'] as $yoga) {
            $fn = 'get' . ucwords($yoga);
            $yogaResult[$yoga] = $yogaDetails->{$fn}();
        }

        $kundliResult = [
            'nakshatraDetails' => $nakshatraResult,
            'mangalDosha' => $mangalDoshaResult,
            'yogas' => $yogaResult,
        ];
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

include __DIR__ . '/../templates/kundli.tpl.php';
