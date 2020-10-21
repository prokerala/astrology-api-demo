<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\BirthDetails;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/calculators-list.php';

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
        $method = new BirthDetails($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime);

        $nakshatra_details = [];

        $additional_info = $result->getAdditionalInfo();
        $nakshatra_additional_info = [];
        $nakshatra_details['nakshatra'] = $result->getNakshatra();
        $nakshatra_details['chandra_rasi'] = $result->getChandraRasi();
        $nakshatra_details['soorya_rasi'] = $result->getSooryaRasi();
        $nakshatra_details['zodiac'] = $result->getZodiac();

        $nakshatra_info_list = ['Deity', 'Ganam', 'Symbol', 'AnimalSign', 'Nadi', 'Color', 'BestDirection', 'Syllables', 'BirthStone', 'Gender', 'Planet', 'EnemyYoni'];
        foreach ($nakshatra_info_list as $data) {
            $function = 'get' . $data;
            $nakshatra_additional_info[$data] = $additional_info->{$function}();
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

include __DIR__ . '/../templates/birth-details.tpl.php';
