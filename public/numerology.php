<?php

declare(strict_types=1);

use Prokerala\Api\Numerology\Service\Pythagorean\AttainmentNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\BalanceNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\BirthdayNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\BirthMonthNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\BridgeNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\CapStoneNumber;
use Prokerala\Api\Numerology\Service\Chaldean\BirthNumber;
use Prokerala\Api\Numerology\Service\Chaldean\DailyNameNumber;
use Prokerala\Api\Numerology\Service\Chaldean\IdentityInitialCode;
use Prokerala\Api\Numerology\Service\Chaldean\WholeNameNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\ChallengeNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\CornerStoneNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\DestinyNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\ExpressionNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\HiddenPassionNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\InnerDreamNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\KarmicDebtNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\LifePathNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\MaturityNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\PersonalDayNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\PersonalityNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\PersonalMonthNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\PersonalYearNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\PinnacleNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\RationalThoughtNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\SoulUrgeNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\SubconsciousSelfNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\UniversalDayNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\UniversalMonthNumber;
use Prokerala\Api\Numerology\Service\Pythagorean\UniversalYearNumber;
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
$datetime = new DateTimeImmutable('now');
$result = [];
$errors = [];
$system = isset($_POST['system']) ? $_POST['system'] : 'pythagorean';
$firstName = null;
$middleName = null;
$lastName = null;
$calculators = [
    'pythagorean' => [
        'attainment-number' => 'Attainment Number',
        'balance-number' => 'Balance Number',
        'birth-month-number' => 'Birth Month Number',
        'birthday-number' => 'Birthday Number',
        'bridge-number' => 'Bridge Number',
        'capstone-number' => 'Capstone Number',
        'challenge-number' => 'Challenge Number',
        'cornerstone-number' => 'Corner Stone Number',
        'destiny-number' => 'Destiny Number',
        'expression-number' => 'Expression Number',
        'hidden-passion-number' => 'Hidden Passion Number',
        'inner-dream-number' => 'Inner Dream Number',
        'karmic-debt-number' => 'Karmic Debt Number',
        'life-path-number' => 'Life Path Number',
        'maturity-number' => 'Maturity Number',
        'personal-day-number' => 'Personal Day Number',
        'personal-month-number' => 'Personal Month Number',
        'personal-year-number' => 'Personal Year Number',
        'personality-number' => 'Personality Number',
        'pinnacle-number' => 'Pinnacle Number',
        'rational-thought-number' => 'Rational Thought Number',
        'soul-urge-number' => 'Soul Urge Number',
        'subconscious-self-number' => 'Subconscious Self Number',
        'universal-day-number' => 'Universal Day Number',
        'universal-month-number' => 'Universal Month Number',
        'universal-year-number' => 'Universal Year Number',
    ],
    'chaldean' => [
        'birth-number' => 'Birth Number',
        'daily-name-number' => 'Daily Name Number',
        'identity-initial-code-number' => 'Identity Initial Code Number',
        'life-path-number' => 'Life Path Number',
        'whole-name-number' => 'Whole Name Number',
    ],
];

$calculatorClass = [
    'pythagorean'=>[
        'life-path-number' => LifePathNumber::class,
        'capstone-number' => CapStoneNumber::class,
        'personality-number' => PersonalityNumber::class,
        'challenge-number' => ChallengeNumber::class,
        'inner-dream-number' => InnerDreamNumber::class,
        'personal-year-number' => PersonalYearNumber::class,
        'expression-number' => ExpressionNumber::class,
        'universal-month-number' => UniversalMonthNumber::class,
        'personal-month-number' => PersonalMonthNumber::class,
        'soul-urge-number' => SoulUrgeNumber::class,
        'destiny-number' => DestinyNumber::class,
        'attainment-number' => AttainmentNumber::class,
        'birthday-number' => BirthdayNumber::class,
        'universal-day-number' => UniversalDayNumber::class,
        'birth-month-number' => BirthMonthNumber::class,
        'universal-year-number' => UniversalYearNumber::class,
        'balance-number' => BalanceNumber::class,
        'personal-day-number' => PersonalDayNumber::class,
        'cornerstone-number' => CornerStoneNumber::class,
        'subconscious-self-number' => SubconsciousSelfNumber::class,
        'maturity-number' => MaturityNumber::class,
        'hidden-passion-number' => HiddenPassionNumber::class,
        'rational-thought-number' => RationalThoughtNumber::class,
        'pinnacle-number' => PinnacleNumber::class,
        'karmic-debt-number' => KarmicDebtNumber::class,
        'bridge-number' => BridgeNumber::class,
    ],
    'chaldean'=>[
        'birth-number' => BirthNumber::class,
        'life-path-number'=> \Prokerala\Api\Numerology\Service\Chaldean\LifePathNumber::class,
        'identity-initial-code-number' => IdentityInitialCode::class,
        'whole-name-number' => WholeNameNumber::class,
        'daily-name-number' => DailyNameNumber::class,
    ],
];

$calculatorParams = [
    'pythagorean' => [
        'date' => [
            'life-path-number',
            'birth-month-number',
            'universal-month-number',
            'birthday-number',
            'universal-day-number',
            'universal-year-number',
            'challenge-number',
            'pinnacle-number',
        ],
        'date_and_reference_year' => [
            'personal-year-number',
            'personal-month-number',
            'personal-day-number',
        ],
        'name' => [
            'capstone-number',
            'destiny-number',
            'expression-number',
            'hidden-passion-number',
            'balance-number',
            'subconscious-self-number',
            'cornerstone-number',

        ],
        'name_and_vowel' => [
            'personality-number',
            'inner-dream-number',
            'soul-urge-number',
        ],
        'date_and_name' => [
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
        'name' => [
            'identity-initial-code-number',
            'whole-name-number',
            'daily-name-number',
        ],
    ],
];
$selectedCalculator = null;
if ($submit) {
    try {
        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : null;
        $middleName = isset($_POST['middleName']) ? $_POST['middleName'] :null;
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] :null;
        $reference = isset($_POST['referenceYear']) ? $_POST['referenceYear'] :null;
        $vowel = isset($_POST['additionalVowel']) ? $_POST['additionalVowel'] : false;
        $system = isset($_POST['system']) ? $_POST['system'] :"";
        $reference = intval($reference);
        $selectedCalculator = isset($_POST['calculatorName']) ? $_POST['calculatorName'] : null;

        if ($selectedCalculator) {
            $calculator = new $calculatorClass[$system][$selectedCalculator]($client);
             if (in_array($selectedCalculator, $calculatorParams[$system]['date'])) {
                $result = $calculator->process($datetime);
            } elseif (in_array($selectedCalculator, $calculatorParams[$system]['name'])) {
                $result = $calculator->process($firstName, $middleName, $lastName);
            } elseif (in_array($selectedCalculator, $calculatorParams[$system]['date_and_name'])) {
                $result = $calculator->process($datetime, $firstName, $middleName, $lastName);
            } elseif (in_array($selectedCalculator, $calculatorParams[$system]['name_and_vowel'])){
                $result = $calculator->process($firstName, $middleName, $lastName, (bool)$vowel);
             } elseif (in_array($selectedCalculator, $calculatorParams[$system]['date_and_reference_year'])){
                 $result = $calculator->process($datetime, $reference);
             } else {
                 throw new \Exception('Selected calculator not found');
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
