<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Result\Planet;
use Prokerala\Api\Astrology\Service\Ashtakavarga;
use Prokerala\Api\Astrology\Service\AshtakavargaChart;
use Prokerala\Api\Astrology\Service\Sarvashtakavarga;
use Prokerala\Api\Astrology\Service\SarvashtakavargaChart;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

function getAshtaVargaChartAndResult(
    Client $client,
    mixed $ayanamsa,
    Location $location,
    DateTimeImmutable $datetime,
    int $planet,
    string $chartStyle,
    string $la
): array {
    $method = new Ashtakavarga($client);
    $chartMethod = new AshtakavargaChart($client);
    $method->setAyanamsa($ayanamsa);
    $chart = $chartMethod->process($location, $datetime, $planet, $chartStyle, $la);
    $result = $method->process($location, $datetime, $planet, $chartStyle, $la);

    return [$chart, $result];
}

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
$sample_name = 'auspicious-yoga';

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
    'ta' => 'Tamil',
    'te' => 'Telugu',
    'ml' => 'Malayalam',
];
$chart_style = 'north-indian';
$timezone = 'Asia/Kolkata';
if ($submit) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $ayanamsa = $_POST['ayanamsa'];
    $chart_style = $_POST['chart_style'];
    $planetId = $_POST['planet'];
    $timezone = $_POST['timezone'] ?? '';
}
$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);

$location = new Location((float)$input['latitude'], (float)$input['longitude'], 0, $tz);

$heading = 'Ashtakavarga';
$tpl_view = 'home';
$chart = '';
$errors = [];
if ($submit) {
    try {
        $tpl_view = 'result';
        $isSarvashtakavarga = 'sarvashtakavarga' === $planetId;
        if ($isSarvashtakavarga) {
            $tpl_view = 'sarvashtakavarga';
            $heading = 'Sarvashtakavarga';
            $method = new Sarvashtakavarga($client);
            $chartMethod = new SarvashtakavargaChart($client);
            $method->setAyanamsa($ayanamsa);
            $chart = $chartMethod->process($location, $datetime, $chart_style, $la);
            $result = $method->process($location, $datetime, $chart_style, $la);

            $ar_ashtakavarga = [];
            foreach (Planet::PLANET_LIST as $planetId => $planetName) {
                if ($planetId > Planet::SATURN) {
                    continue;
                }
                [$ashtakavarga_chart, $ashtakavarga_result] = getAshtaVargaChartAndResult($client, $ayanamsa, $location, $datetime, $planetId, $chart_style, $la);
                $ar_ashtakavarga[] = [
                    'planet' => $planetName,
                    'chart' => $ashtakavarga_chart,
                    'result' => $ashtakavarga_result,
                ];
            }
        } else {
            [$chart, $result] = getAshtaVargaChartAndResult($client, $ayanamsa, $location, $datetime, (int)$planetId, $chart_style, $la);
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

include DEMO_BASE_DIR . '/templates/ashtakavarga.tpl.php';
