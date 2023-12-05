<?php

declare(strict_types=1);

use Prokerala\Api\Horoscope\Result\DailyHoroscope;
use Prokerala\Api\Horoscope\Service\DailyPrediction;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

require __DIR__ . '/bootstrap.php';

$calculators = [];

$submit = $_POST['submit'] ?? 0;

$sample_name = 'daily-horoscope';

$timezone = 'Asia/Kolkata';
$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable('now', $tz);
$signs = [
    'aries' => 'Aries',
    'taurus' => 'Taurus',
    'gemini' => 'Gemini ',
    'cancer' => 'Cancer ',
    'leo' => 'Leo',
    'virgo' => 'Virgo',
    'libra' => 'Libra',
    'scorpio' => 'Scorpio',
    'sagittarius' => 'Sagittarius',
    'capricorn' => 'Capricorn ',
    'aquarius' => 'Aquarius',
    'pisces' => 'Pisces',
];
$day = $_GET['day'] ?? 'today';
$selectedSign = $_GET['sign'] ?? null;
$tomorrow = new DateTimeImmutable('+1 day', $tz);
$yesterday = new DateTimeImmutable('-1 day', $tz);

$errors = [];
$result = null;
if ($selectedSign) {
    try {
        $horoscopeClass = new DailyPrediction($client);
        $cache = new FilesystemAdapter();
        $result = $cache->get("daily_horoscope_{$selectedSign}", function (ItemInterface $item) use ($horoscopeClass, $datetime, $selectedSign): DailyHoroscope {
            $item->expiresAfter(28800);
            return $horoscopeClass->process($datetime, $selectedSign);
        });

        $signName = $result->getDailyHoroscopePrediction()->getSignName();
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
    } catch (\Psr\Cache\InvalidArgumentException $e) {
        $errors = ['message' => "API Request Failed with error {$e->getMessage()}"];
    }
}

$apiCreditUsed = $client->getCreditUsed();

include DEMO_BASE_DIR . '/templates/daily-horoscope.tpl.php';
