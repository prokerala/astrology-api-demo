<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\PlanetPosition;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;

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
        $method = new PlanetPosition($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime);
        $planetPositions = $result->getPlanetPosition();
        $planetPositionResult = [];
        foreach ($planetPositions as $position) {
            $deg = floor($position->getDegree());
            $fraction = $position->getDegree() - $deg;

            $temp = $fraction * 3600;
            $min = floor($temp / 60);
            $sec = $temp - ($min * 60);
            $planetPositionResult[] = [
                'id' => $position->getId(),
                'name' => $position->getName(),
                'longitude' => $position->getLongitude(),
                'isReverse' => $position->isReverse(),
                'position' => $position->getPosition(),
                'degree' => $deg . '&deg; ' . $min . "' ",
                'rasi' => $position->getRasi(),
                'rasiLord' => $position->getRasi()->getLord()->getVedicName(),
                'rasiLordEn' => $position->getRasi()->getLord(),
            ];
        }
    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
        $errors['message'] = 'ERROR: You have exceeded your quota allocation for the day';
    } catch (RateLimitExceededException $e) {
        $errors['message'] = 'ERROR: Rate limit exceeded. Throttle your requests.';
    } catch (AuthenticationException $e) {
        $errors = ['message' => $e->getMessage()];
    } catch (Exception $e){
        $errors = ['message' => "API Request Failed with error {$e->getMessage()}"];
    }
}

include __DIR__ . '/../templates/planet-position.tpl.php';
