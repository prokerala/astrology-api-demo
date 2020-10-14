<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\KaalSarpDosha;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/../vendor/autoload.php';

$client = include __DIR__ . '/../client.php';

$input = [
    'datetime' => '1967-08-29T09:00:00+05:30',
    'latitude' => '19.0821978',
    'longitude' => '72.7411014', // Mumbai
];
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;

if ($submit) {
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
        $method = new KaalSarpDosha($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime);

        $kaalSarpDoshaResult = [];
        $kaalSarpDoshaResult['kaal_sarp_type'] = $result->getKaalSarpType();
        $kaalSarpDoshaResult['kaal_sarp_dosha_type'] = $result->getKaalSarpDoshaType();
        $kaalSarpDoshaResult['has_kaal_sarp_dosha'] = $result->hasKaalSarpDosha();
        $kaalSarpDoshaResult['description'] = $result->getDescription();
    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
    } catch (RateLimitExceededException $e) {
    }
}
include __DIR__ . '/../templates/kaal-sarp-dosha.tpl.php';
