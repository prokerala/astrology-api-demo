<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';


$calculators = [];
$months = array(
     1 => 'January',
     2 => 'February',
     3 => 'March',
     4 => 'April',
     5 => 'May',
     6 => 'June',
     7 => 'July',
     8 => 'August',
     9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December ');
$years = range(1980,2022);
$m31 = range(1,31);
$m30 = range(1,30);
$m28 = range(1,28);

if(isset($_POST['datetime'])){
    $time = new DateTimeImmutable($_POST['datetime']);
    $input = [
        'datetime' => $time->format('c'),
        'latitude' => '19.0821978',
        'longitude' => '72.7411014', // Mumbai
    ];
}
else{
    $time = new DateTimeImmutable();
    $input = [
        'datetime' => $time->format('c'),
        'latitude' => '19.0821978',
        'longitude' => '72.7411014', // Mumbai
    ];

}
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;
$sample_name = '';

if ($submit) {
    $input['datetime'] = $_POST['datetime'];
}
$timezone = 'Asia/Kolkata';
$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);

$result = [];
$errors = [];

$vowel = "yw";
$reference = 1;
$firstName = "";
$middleName = '';
$lastName = "";
$calculators = [
    'pythagorean' => [
        'life-cycle' => 'Life Cycle',
        'life-path-number' => 'Life Path Number',
        'cap-stone-number' => 'Cap Stone Number',
        'personality-number' => 'Personality Number',
        'challenge-number' => 'Challenge Number',
        'inner-dream-number' => 'Inner Dream Number',
        'personal-year-number' => 'Personal Year Number',
        'expression-number' => 'Expression Number',
        'universal-month-number' => 'Universal Month Number',
        'personal-month-number' => 'Personal Month Number',
        'soul-urge-number' => 'Soul Urge Number',
        'destiny-number' => 'Destiny Number',
        'attainment-number' => 'Attainment Number',
        'birth-day-number' => 'Birth Day Number',
        'universal-day-number' => 'Universal Day Number',
        'birth-month-number' => 'Birth Month Number',
        'universal-year-number' => 'UniversalYearNumber',
        'balance-number' => 'Balance Number',
        'personal-day-number' => 'Personal Day Number',
        'corner-stone-number' => 'Corner Stone Number',
        'subconscious-self-number' => 'Subconscious Self Number',
        'maturity-number' => 'Maturity Number',
        'hidden-passion-number' => 'Hidden Passion Number',
        'rational-thought-number' => 'Rational Thought Number',
        'pinnacle-number' =>'Pinnacle Number',
        'karmic-debt-number'=> 'Karmic Debt Number',
        'bridge-number' =>'Bridge Number',
    ],
    'chaldean' => [
        'birth-number' => 'Birth Number',
        'life-path-number' => 'Life Path Number',
        'identity-initial-code-number' => 'Identity Initial Code Number',


    ]
];

$calculatorClass = [
    'pythagorean'=>[
        'life-cycle' => \Prokerala\Api\Numerology\Service\LifeCycle::class,
        'life-path-number' => \Prokerala\Api\Numerology\Service\LifePathNumber::class,
        'cap-stone-number' => \Prokerala\Api\Numerology\Service\CapStoneNumber::class,
        'personality-number' => \Prokerala\Api\Numerology\Service\PersonalityNumber::class,
        'challenge-number' => \Prokerala\Api\Numerology\Service\ChallengeNumber::class,
        'inner-dream-number' => \Prokerala\Api\Numerology\Service\InnerDreamNumber::class,
        'personal-year-number' => \Prokerala\Api\Numerology\Service\PersonalYearNumber::class,
        'expression-number' => \Prokerala\Api\Numerology\Service\ExpressionNumber::class,
        'universal-month-number' => \Prokerala\Api\Numerology\Service\UniversalMonthNumber::class,
        'personal-month-number' => \Prokerala\Api\Numerology\Service\PersonalMonthNumber::class,
        'soul-urge-number' => \Prokerala\Api\Numerology\Service\SoulUrgeNumber::class,
        'destiny-number' => \Prokerala\Api\Numerology\Service\DestinyNumber::class,
        'attainment-number' => \Prokerala\Api\Numerology\Service\AttainmentNumber::class,
        'birth-day-number' => \Prokerala\Api\Numerology\Service\BirthDayNumber::class,
        'universal-day-number' => \Prokerala\Api\Numerology\Service\UniversalDayNumber::class,
        'birth-month-number' => \Prokerala\Api\Numerology\Service\BirthMonthNumber::class,
        'universal-year-number' => \Prokerala\Api\Numerology\Service\UniversalYearNumber::class,
        'balance-number' => \Prokerala\Api\Numerology\Service\BalanceNumber::class,
        'personal-day-number' => \Prokerala\Api\Numerology\Service\PersonalDayNumber::class,
        'corner-stone-number' => \Prokerala\Api\Numerology\Service\CornerStoneNumber::class,
        'subconscious-self-number' => \Prokerala\Api\Numerology\Service\SubconsciousSelfNumber::class,
        'maturity-number' => \Prokerala\Api\Numerology\Service\MaturityNumber::class,
        'hidden-passion-number' => \Prokerala\Api\Numerology\Service\HiddenPassionNumber::class,
        'rational-thought-number' => \Prokerala\Api\Numerology\Service\RationalThoughtNumber::class,
        'pinnacle-number' => \Prokerala\Api\Numerology\Service\PinnacleNumber::class,
        'karmic-debt-number' => \Prokerala\Api\Numerology\Service\KarmicDebtNumber::class,
        'bridge-number' =>\Prokerala\Api\Numerology\Service\BridgeNumber::class
        ],
    'chaldean'=>[
        'birth-number' => \Prokerala\Api\Numerology\Service\Chaldean\BirthNumber::class,
        'life-path-number'=> \Prokerala\Api\Numerology\Service\Chaldean\LifePathNumber::class,
        'identity-initial-code-number' => \Prokerala\Api\Numerology\Service\Chaldean\IdentityInitialCode::class,
    ],
];

$calculatorParams = [
    'pythagorean' => [
        'date' => [
            'life-path-number',
            'birth-month-number',
            'corner-stone-number',
            'universal-month-number',
            'birth-day-number',
            'universal-day-number',
            'universal-year-number',
            'challenge-number',
            'pinnacle-number'
        ],
        'date_and_reference_year' =>[
            'personal-year-number',
            'personal-month-number',
            'personal-day-number'
        ],
        'name' => [
            'cap-stone-number',
            'destiny-number',
            'expression-number',
            'hidden-passion-number',
            'balance-number',
            'subconscious-self-number',
            'soul-urge-number',
        ],
        'name_and_vowel' =>[
            'personality-number',
            'inner-dream-number',
        ],
        'date_and_name' =>[
            'attainment-number',
            'maturity-number',
            'rational-thought-number',
            'karmic-debt-number',
            'bridge-number',
        ],
    ],
    'chaldean' => [
        'date' => [
            'birth-number',
            'life-path-number',
        ],
        'name' =>[
            'identity-initial-code-number',
        ],
        'date_and_name' =>[],
        'name_and_vowel' =>[],
        'date_and_reference_year' =>[],
    ]
];

if ($submit) {
    try {
        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : null;
        $middleName = isset($_POST['middleName']) ? $_POST['middleName'] :null;
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] :null;
        $reference = isset($_POST['referenceYear']) ? $_POST['referenceYear'] :null;
        $vowel = isset($_POST['additionalVowel']) ? $_POST['additionalVowel'] :"";
        $system = isset($_POST['system']) ? $_POST['system'] :"";


        $calculatorValue = isset($_POST['calculatorName']) ? $_POST['calculatorName'] : null;
        $calculatorKey = str_replace(' ', '-',strtolower($calculatorValue));
        if ($calculatorValue) {
            $calculator = new $calculatorClass[$system][$calculatorKey]($client);
             if (in_array($calculatorKey, $calculatorParams[$system]['date'])) {
                $result = $calculator->process($datetime);
            } else if (in_array($calculatorKey, $calculatorParams[$system]['name'])) {
                $result = $calculator->process($firstName, $middleName, $lastName);
            } else if (in_array($calculatorKey, $calculatorParams[$system]['date_and_name'])) {
                $result = $calculator->process($datetime, $firstName, $middleName, $lastName);
            }
             elseif(in_array(str_replace(' ', '-',strtolower($calculatorValue)),$calculatorParams[$system]['name_and_vowel'])){
                 $calculator->process($firstName,$middleName,$lastName,$vowel);
             }
             elseif(in_array(str_replace(' ', '-',strtolower($calculatorValue)),$calculatorParams[$system]['date_and_reference_year'])){
                 $calculator->process($datetime,$reference);
             }
             else{
                 echo('CALCULATOR NOT FOUND');
                 exit();
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
include DEMO_BASE_DIR . '/templates/numerology.tpl.php';
