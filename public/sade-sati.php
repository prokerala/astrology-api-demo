<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\SadeSati;
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
$result_type = 'basic';
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;

if (isset($_POST['submit'])) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $result_type = $_POST['result_type'];
    $ayanamsa = $_POST['ayanamsa'];
}

$datetime = new DateTimeImmutable($input['datetime']);
$tz = $datetime->getTimezone();

$location = new Location($input['latitude'], $input['longitude'], 0, $tz);

$result = [];
$errors = [];

if($submit){
    try {
        $advanced = 'advanced' === $result_type ? true : false;

        $sade_sati = new SadeSati($client);
        $sade_sati->setAyanamsa($ayanamsa);
        $result = $sade_sati->process($location, $datetime, $advanced);

        $sadeSatiResult = [
            'isInSadeSati' => $result->isInSadeSati(),
            'transitPhase' => $result->getTransitPhase(),
            'description' => $result->getDescription(),
        ];

        if ($advanced) {
            $transitData = [];
            $transit = $result->getTransits();
            foreach ($transit as $data) {
                $transitData[] = [
                    'phase' => $data->getPhase(),
                    'start' => new DateTimeImmutable($data->getStart()),
                    'end' => new DateTimeImmutable($data->getEnd()),
                ];
            }
            $sadeSatiResult['transits'] = $transitData;
        }
    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
    } catch (RateLimitExceededException $e) {
    }
}

include __DIR__ . '/../templates/sade-sati.tpl.php';
