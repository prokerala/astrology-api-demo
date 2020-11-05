<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\Kundli;
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
$result_type = 'basic';
$ayanamsa = 1;
$sample_name = 'kundli';

$timezone = 'Asia/Kolkata';
if (isset($_POST['submit'])) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $ayanamsa = $_POST['ayanamsa'];
    $result_type = $_POST['result_type'];
    $timezone = $_POST['timezone'] ?? '';
}

$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);

$location = new Location($input['latitude'], $input['longitude'], 0, $tz);


$result = [];
$errors = [];

if ($submit) {
    try {
        $advanced = 'advanced' === $result_type ? true : false;

        $method = new Kundli($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime, $advanced);

        $nakshatraDetails = $result->getNakshatraDetails();
        $nakshatra = $nakshatraDetails->getNakshatra();
        $nakshatraLord = $nakshatra->getLord();

        $chandraRasi = $nakshatraDetails->getChandraRasi();
        $chandraRasiLord = $chandraRasi->getLord();

        $sooryaRasi = $nakshatraDetails->getSooryaRasi();
        $sooryaRasiLord = $sooryaRasi->getLord();

        $zodiac = $nakshatraDetails->getZodiac();

        $additionalInfo = $nakshatraDetails->getAdditionalInfo();

        $mangalDosha = $result->getMangalDosha();

        $yogaDetails = $result->getYogaDetails();

        $kundliResult = [
            'nakshatraDetails' => [

                'nakshatra' => [
                    'id' => $nakshatra->getId(),
                    'name' => $nakshatra->getName(),
                    'lord' => [
                        'id' => $nakshatraLord->getId(),
                        'name' => $nakshatraLord->getName(),
                        'vedicName' => $nakshatraLord->getVedicName(),
                    ],
                    'pada' => $nakshatra->getPada(),
                ],
                'chandraRasi' => [
                    'id' => $chandraRasi->getId(),
                    'name' => $chandraRasi->getName(),
                    'lord' => [
                        'id' => $chandraRasiLord->getId(),
                        'name' => $chandraRasiLord->getName(),
                        'vedicName' => $chandraRasiLord->getVedicName(),
                    ],
                ],
                'sooryaRasi' =>  [
                    'id' => $sooryaRasi->getId(),
                    'name' => $sooryaRasi->getName(),
                    'lord' => [
                        'id' => $sooryaRasiLord->getId(),
                        'name' => $sooryaRasiLord->getName(),
                        'vedicName' => $sooryaRasiLord->getVedicName(),
                    ],
                ],
                'zodiac' =>  [
                    'id' => $zodiac->getId(),
                    'name' => $zodiac->getName(),
                ],
                'additionalInfo' => [
                    'deity' => $additionalInfo->getDeity(),
                    'ganam' => $additionalInfo->getGanam(),
                    'symbol' => $additionalInfo->getSymbol(),
                    'animalSign' => $additionalInfo->getAnimalsign(),
                    'nadi' => $additionalInfo->getNadi(),
                    'color' => $additionalInfo->getColor(),
                    'bestDirection' => $additionalInfo->getBestdirection(),
                    'syllables' => $additionalInfo->getSyllables(),
                    'birthStone' => $additionalInfo->getBirthstone(),
                    'gender' => $additionalInfo->getGender(),
                    'planet' => $additionalInfo->getPlanet(),
                    'enemyYoni' => $additionalInfo->getEnemyYoni(),
                ],
            ],
            'mangalDosha' => [
                'hasDosha' => $mangalDosha->hasDosha(),
                'description' => $mangalDosha->getDescription(),
            ],
        ];

        $yogaDetailResult = [];

        foreach ($yogaDetails as $details) {
            $yogaDetailResult[] = [
                'name' => $details->getName(),
                'description' => $details->getDescription(),
            ];
        }

        if ($advanced) {
            $kundliResult['mangalDosha'] = [
                'hasDosha' => $mangalDosha->hasDosha(),
                'description' => $mangalDosha->getDescription(),
                'hasException' => $mangalDosha->hasException(),
                'type' => $mangalDosha->getType(),
                'exceptions' => $mangalDosha->getExceptions(),
            ];

            $yogaDetailResult = [];

            foreach ($yogaDetails as $details) {
                $yogaList = $details->getYogaList();
                $yogas = [];
                    foreach ($yogaList as $yoga) {
                        $yogas[] = [
                            'name' => $yoga->getName(),
                            'hasYoga' => $yoga->hasYoga(),
                            'description' => $yoga->getDescription(),
                        ];
                    }
                    $yogaDetailResult[] = [
                        'name' => $details->getName(),
                        'description' => $details->getDescription(),
                        'yogaList' => $yogas,
                    ];
            }

            $kundliResult['yogaDetails'] = $yogaDetailResult;

            $dashaPeriods = $result->getDashaPeriods();
            $dashaPeriodResult = [];
            foreach ($dashaPeriods as $dashaPeriod) {
                 $antardashas = $dashaPeriod->getAntardasha();
                $antardashaResult = [];
                foreach ($antardashas as $antardasha) {
                    $pratyantardashas = $antardasha->getPratyantardasha();
                    $pratyantardashaResult = [];
                    foreach ($pratyantardashas as $pratyantardasha) {
                        $pratyantardashaResult[] = [
                            'id' => $pratyantardasha->getId(),
                            'name' => $pratyantardasha->getName(),
                            'start' => $pratyantardasha->getStart(),
                            'end' => $pratyantardasha->getEnd(),
                        ];
                    }
                    $antardashaResult[]  = [
                        'id' => $antardasha->getId(),
                        'name' => $antardasha->getName(),
                        'start' => $antardasha->getStart(),
                        'end' => $antardasha->getEnd(),
                        'pratyantardasha' => $pratyantardashaResult
                    ];
                }
                $dashaPeriodResult[] = [
                    'id' => $dashaPeriod->getId(),
                    'name' => $dashaPeriod->getName(),
                    'start' => $dashaPeriod->getStart(),
                    'end' => $dashaPeriod->getEnd(),
                    'antardasha' => $antardashaResult
                ];
            }
            $kundliResult['dashaPeriods'] = $dashaPeriodResult;

        }
        $kundliResult['yogaDetails'] = $yogaDetailResult;


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
include DEMO_BASE_DIR . '/templates/kundli.tpl.php';
