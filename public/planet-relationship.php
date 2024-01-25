<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Result\Planet;
use Prokerala\Api\Astrology\Service\PlanetRelationship;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$time_now = new DateTimeImmutable();
$planet_order = [
    Planet::SUN => 'Sun',
    Planet::MOON => 'Moon',
    Planet::MERCURY => 'Mercury',
    Planet::VENUS => 'Venus',
    Planet::MARS => 'Mars',;
    Planet::JUPITER => 'Jupiter',
    Planet::SATURN => 'Saturn',
];
$input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '19.0821978',
    'longitude' => '72.7411014', // Mumbai
];
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$submit = $_POST['submit'] ?? 0;
$la = $_POST['la'] ?? 'en';
$ayanamsa = 1;
$sample_name = 'planet-relationship';
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

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
    'ta' => 'Tamil',
    'ml' => 'Malayalam',
    'te' => 'Telugu',
];

$result = [];
$errors = [];

if ($submit) {
    try {
        $method = new PlanetRelationship($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime, $la);
        $planetRelationships = $result->getPlanetRelationship();
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

include DEMO_BASE_DIR . '/templates/planet-relationship.tpl.php';
