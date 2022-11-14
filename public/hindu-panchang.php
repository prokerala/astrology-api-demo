<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\AnandadiYoga;
use Prokerala\Api\Astrology\Service\DishaShool;
use Prokerala\Api\Astrology\Service\Hora;
use Prokerala\Api\Astrology\Service\Panchang;
use Prokerala\Api\Astrology\Service\Ritu;
use Prokerala\Api\Astrology\Service\Solstice;
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
$ayanamsa = 1;
$la = $_POST['la'] ?? 'en';
$sample_name = 'panchang';

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
$errors = [];
$horaResult = [];
$rituResult = [];
$solsticeResult = [];
$anandadiYogaResult = [];
$dishaShoolResult = [];

$arSupportedLanguages = [
    'en' => 'English',
    'hi' => 'Hindi',
];
$apiCreditUsed = 0;
if ($submit) {
    try {
        $method = new Panchang($client);
        $method->setAyanamsa($ayanamsa);
        $method->setTimeZone($tz);
        $result = $method->process($location, $datetime, true, $la);
        $apiCreditUsed += $client->getCreditUsed();

        $method = new Hora($client);
        $method->setAyanamsa($ayanamsa);
        $method->setTimeZone($tz);
        $horaResult = $method->process($location, $datetime, $la);
        $apiCreditUsed += $client->getCreditUsed();

        $method = new Ritu($client);
        $method->setAyanamsa($ayanamsa);
        $method->setTimeZone($tz);
        $rituResult = $method->process($location, $datetime, $la);
        $apiCreditUsed += $client->getCreditUsed();

        $method = new Solstice($client);
        $method->setAyanamsa($ayanamsa);
        $method->setTimeZone($tz);
        $solsticeResult = $method->process($location, $datetime, $la);
        $apiCreditUsed += $client->getCreditUsed();

        $method = new DishaShool($client);
        $method->setAyanamsa($ayanamsa);
        $method->setTimeZone($tz);
        $dishaShoolResult = $method->process($location, $datetime, $la);
        $apiCreditUsed += $client->getCreditUsed();

        $panchangResult = [
            'sunrise' => $result->getSunrise(),
            'sunset' => $result->getSunset(),
            'moonrise' => $result->getMoonrise(),
            'moonset' => $result->getMoonset(),
            'vaara' => $result->getVaara(),
        ];

        $panchang = [];
        $panchang['Nakshatra'] = $result->getNakshatra();
        $panchang['Tithi'] = $result->getTithi();
        $panchang['Karana'] = $result->getKarana();
        $panchang['Yoga'] = $result->getYoga();

        $data_list = ['Nakshatra', 'Tithi', 'Karana', 'Yoga'];

        foreach ($data_list as $key) {
            foreach ($panchang[$key] as $idx => $data) {
                $panchangResult[$key][$idx] = [
                    'id' => $data->getId(),
                    'name' => $data->getName(),
                    'start' => $data->getStart(),
                    'end' => $data->getEnd(),
                ];
                if ('Nakshatra' === $key) {
                    $panchangResult[$key][$idx]['nakshatra_lord'] = $data->getLord();
                } elseif ('Tithi' === $key) {
                    $panchangResult[$key][$idx]['paksha'] = $data->getPaksha();
                }
            }
        }

        $auspicious_fields = ['abhijitMuhurat', 'amritKaal', 'brahmaMuhurat'];
        $inauspicious_fields = ['rahuKaal', 'yamagandaKaal', 'gulikaKaal', 'durMuhurat', 'varjyam'];

        $auspicious_periods = $result->getAuspiciousPeriod();
        $inauspicious_period = $result->getInauspiciousPeriod();

        foreach ($auspicious_periods as $data) {
            $field = $data->getName();
            $periods = $data->getPeriod();
            foreach ($periods as $period) {
                $auspiciousPeriod[$field][] = [
                    'start' => $period->getStart(),
                    'end' => $period->getEnd(),
                ];
            }
        }

        foreach ($inauspicious_period as $data) {
            $field = $data->getName();
            $periods = $data->getPeriod();
            foreach ($periods as $period) {
                $inAuspiciousPeriod[$field][] = [
                    'start' => $period->getStart(),
                    'end' => $period->getEnd(),
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

include DEMO_BASE_DIR . '/templates/hindu-panchang.tpl.php';
