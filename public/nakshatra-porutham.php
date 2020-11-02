<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\NakshatraProfile;
use Prokerala\Api\Astrology\Service\NakshatraPorutham;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/nakshatra-list.php';
require __DIR__ . '/bootstrap.php';

$girl_nakshatra = 0;
$girl_nakshatra_pada = 2;
$boy_nakshatra = 13;
$boy_nakshatra_pada = 3;

$result_type = 'basic';
$sample_name = 'nakshatra-porutham';
$submit = $_POST['submit'] ?? 0;
$result = [];
$errors = [];

if ($submit) {
    $girl_nakshatra = $_POST['girl_nakshatra'];
    $girl_nakshatra_pada = $_POST['girl_nakshatra_pada'];
    $boy_nakshatra = $_POST['boy_nakshatra'];
    $boy_nakshatra_pada = $_POST['boy_nakshatra_pada'];
    $result_type = $_POST['result_type'];

    try {
        $advanced = 'advanced' === $result_type;

        $girl_profile = new NakshatraProfile((int)$girl_nakshatra, (int)$girl_nakshatra_pada);
        $boy_profile = new NakshatraProfile((int)$boy_nakshatra, (int)$boy_nakshatra_pada);

        $nakshatra_porutham = new NakshatraPorutham($client);
        $result = $nakshatra_porutham->process($girl_profile, $boy_profile, $advanced);

        $compatibilityResult = [];

        $compatibilityResult['maximumPoint'] = $result->getMaximumPoints();
        $compatibilityResult['ObtainedPoint'] = $result->getObtainedPoints();
        $message = $result->getMessage();
        $compatibilityResult['message'] = [
            'type' => $message->getType(),
            'description' => $message->getDescription(),
        ];
        $compatibilityResult['Matches'] = [];

        foreach ($result->getMatches() as $idx => $match) {
            $compatibilityResult['Matches'][$idx] = [
                'id' => $match->getId(),
                'name' => $match->getName(),
                'hasPorutham' => $match->hasPorutham(),
            ];
            if ($advanced) {
                $compatibilityResult['Matches'][$idx]['poruthamStatus'] = $match->getPoruthamStatus();
                $compatibilityResult['Matches'][$idx]['points'] = $match->getPoints();
                $compatibilityResult['Matches'][$idx]['description'] = $match->getDescription();
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

$apiCreditUsed = $client->getCreditUsed();
include DEMO_BASE_DIR . '/templates/nakshatra-porutham.tpl.php';
