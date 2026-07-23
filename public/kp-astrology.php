<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\KpChart;
use Prokerala\Api\Astrology\Service\KpHouseSignificator;
use Prokerala\Api\Astrology\Service\KpPlanetPosition;
use Prokerala\Api\Astrology\Service\KpPlanetSignificator;
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
$ayanamsa = 1;
$chart_style = 'south-indian';
$sample_name = 'chart';

$totalCredits = 0;

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
    'ta' => 'Tamil',
    'te' => 'Telugu',
    'ml' => 'Malayalam',
];

$timezone = 'Asia/Kolkata';
if ($submit) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $chart_style = $_POST['chart_style'];
    $timezone = $_POST['timezone'] ?? '';
    $la = $_POST['la'] ?? 'en';
}

$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);

$location = new Location((float)$input['latitude'], (float)$input['longitude'], 0, $tz);

$result = [];
$errors = [];


if ($submit) {
    try {
        validateDateTime(
            $input['datetime'],
            $tz,
            new DateTimeImmutable('-1 day',$tz),
            new DateTimeImmutable('+1 day',$tz)
        );

        $kpChart = new KpChart($client);
        $kpChart->setAyanamsa($ayanamsa);
        $result = $kpChart->process($location, $datetime, $la, $chart_style);
        $totalCredits += $client->getCreditUsed();

        $kpPlanetPosition = new KpPlanetPosition($client);
        $kpPlanetPosition->setAyanamsa($ayanamsa);
        $resultOne = $kpPlanetPosition->process($location, $datetime, $la);
        $totalCredits += $client->getCreditUsed();

        $planetPositions = $resultOne->getPlanetPosition();

        $planetPositionResult = [];

        foreach ($planetPositions as $position) {


            $deg = floor($position->getSignDegree());
            $fraction = $position->getSignDegree() - $deg;

            $temp = $fraction * 3600;
            $min = floor($temp / 60);
            $sec = $temp - ($min * 60);

            $planetPositionResult[] = [
                'name' => $position->getPlanet()->getName(),
                'longitude' => $position->getLongitude(),
                'house' => $position->getHouse()->getNumber(),
                'nakshatra' => $position->getNakshatra()->getname(),
                'nakshatraLord' => $position->getNakshatra()->getLord()->getName(),
                'subLord' => $position->getSubLord()->getName(),
                'subSubLord' => $position->getSubSubLord()->getName(),
                'degree' => $deg . '&deg; ' . $min . "' ",
                'rasi' => $position->getRasi(),
                'rasiLord' => $position->getRasi()->getLord()->getVedicName(),
                'rasiLordEn' => $position->getRasi()->getLord(),
            ];
        }

        $houses = $resultOne->getHouses();

        $housesResult = [];

        foreach ($houses as $house) {


            $deg = floor($house->getEndCusp()->getDegree());
            $fraction = $house->getEndCusp()->getDegree() - $deg;

            $temp = $fraction * 3600;
            $min = floor($temp / 60);
            $sec = $temp - ($min * 60);

            $housesResult[] = [
                'house' => $house->getHouse()->getName(),
                'rasi' => $house->getRasi()->getName(),
                'degree' => $deg . '&deg; ' . $min . "' ",
                'nakshatra' => $house->getRasi()->getName(),
                'nakshatra_lord' => $house->getRasi()->getName(),
                'sub_lord' => $house->getRasi()->getName(),
                'sub_sub_lord' => $house->getRasi()->getName(),
            ];
        }

        $kpPlanetSignificator = new KpPlanetSignificator($client);
        $kpPlanetSignificator->setAyanamsa($ayanamsa);
        $resultTwo = $kpPlanetSignificator->process($location, $datetime, $la);
        $totalCredits += $client->getCreditUsed();

        $planetPositions = $resultTwo->getKpPositions();

        $planetsignificatorResult = [];

        foreach ($planetPositions as $position) {
            $planetsignificatorResult[] = [
                'planet' => $position->getPlanet()->getName(),
                'nakshatra_lord_house' => $position->getNakshatraLordHouse()->getName(),
                'occupied_house' => $position->getOccupiedHouse()->getName(),
                'rasi_lord_house' => $position->getRasiLordHouse(),
                'rasi_lord_own_house' => $position->getRasiLordOwnHouse(),
            ];
        }

        $kpHouseSignificator = new KpHouseSignificator($client);
        $kpHouseSignificator->setAyanamsa($ayanamsa);
        $resultThree = $kpHouseSignificator->process($location, $datetime, $la);
        $totalCredits += $client->getCreditUsed();

        $planetPositions = $resultThree->getKpPositions();

        $houseSignificatorResult = [];

        foreach ($planetPositions as $position) {
            $houseSignificatorResult[] = [
                'house' => $position->getHouse()->getNumber(),
                'nakshatraOccupants' => $position->getCuspNakshatraOccupants(),
                'occupants' => $position->getCuspOccupants(),
                'nakshatraPlanets' => $position->getCuspOwnerNakshatraPlanets(),
                'cuspOwner' => $position->getCuspOwner()->getName(),
            ];
        }

    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
        $errorsQuota = ['message' => '<p class="">The demo is currently disabled. You may request access to the demo by contacting our support team.</p><p class="">Please note that the demo page <span class="b">does not use credits from your account.</span> You can also download the full source code of this demo from the following link: <a href="https://github.com/prokerala/astrology-api-demo">https://github.com/prokerala/astrology-api-demo</a></p><div class=""><a href="https://api.prokerala.com/account/contact" class="btn btn-sm btn-info b">Request Demo</a></div>'];
    } catch (RateLimitExceededException $e) {
        $errors['message'] = 'ERROR: Rate limit exceeded. Throttle your requests.';
    } catch (AuthenticationException $e) {
        $errors = ['message' => $e->getMessage()];
    } catch (Exception $e) {
        $errors = ['message' => "API Request Failed with error {$e->getMessage()}"];
    }
}

$apiCreditUsed = $totalCredits;

include DEMO_BASE_DIR . '/templates/kp-astrology.tpl.php';
