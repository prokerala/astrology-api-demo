<?php

declare(strict_types=1);

use Prokerala\Api\Horoscope\Service\DailyPrediction;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;


require __DIR__ . '/bootstrap.php';


$calculators = [];


$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$sample_name = '';
$timezone = 'Asia/Kolkata';
$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable('now', $tz);
$signs = [
    'aries' => 'Aries',
    'taurus' =>'Taurus' ,
    'gemini' =>'Gemini ',
    'cancer' =>'Cancer ',
     'leo' => 'Leo',
    'virgo' => 'Virgo',
    'libra' =>'Libra',
    'scorpio' =>'Scorpio',
    'sagittarius' =>'Sagittarius',
    'capricorn'=>'Capricorn ',
    'aquarius' => 'Aquarius',
    'pisces' =>'Pisces',
    ];
$dateSelected = $_GET['date'] ?? 'today';
$selectedSign = $_GET['sign'] ?? null;
$tommorow = $datetime->add(new DateInterval('P1D'));
$yesterday = $datetime->sub(new DateInterval('P1D'));
$resultToday = [];
$errors = [];
if ($selectedSign) {
    try {
        $horoscopeClass = new DailyPrediction($client);
        $resultYesterday = $horoscopeClass->process($yesterday,$selectedSign);
        $resultToday = $horoscopeClass->process($datetime,$selectedSign);
        $resultTommorow = $horoscopeClass->process($tommorow,$selectedSign);
        $signName = $resultToday->getDailyHoroscopePrediction()->getSignName();
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
include DEMO_BASE_DIR . '/templates/daily-horoscope.tpl.php';
