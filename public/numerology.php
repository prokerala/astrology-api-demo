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
use Prokerala\Api\Numerology\Service\Chaldean\LifePathNumber as ChaldeanLifePathNumber;
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
$sample_name = 'numerology';
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
        'attainment-number' => ['class' => AttainmentNumber::class, 'name' => 'Attainment Number'],
        'balance-number' => ['class' => BalanceNumber::class, 'name' => 'Balance Number'],
        'birth-month-number' => ['class' => BirthMonthNumber::class, 'name' => 'Birth Month Number'],
        'birthday-number' => ['class' => BirthdayNumber::class, 'name' => 'Birthday Number'],
        'bridge-number' => ['class' => BridgeNumber::class, 'name' => 'Bridge Number'],
        'capstone-number' => ['class' => CapStoneNumber::class, 'name' => 'Capstone Number'],
        'challenge-number' => ['class' => ChallengeNumber::class, 'name' => 'Challenge Number'],
        'cornerstone-number' => ['class' => CornerStoneNumber::class, 'name' => 'Corner Stone Number'],
        'destiny-number' => ['class' => DestinyNumber::class, 'name' => 'Destiny Number'],
        'expression-number' => ['class' => ExpressionNumber::class, 'name' => 'Expression Number'],
        'hidden-passion-number' => ['class' => HiddenPassionNumber::class, 'name' => 'Hidden Passion Number'],
        'inner-dream-number' => ['class' => InnerDreamNumber::class, 'name' => 'Inner Dream Number'],
        'karmic-debt-number' => ['class' => KarmicDebtNumber::class, 'name' => 'Karmic Debt Number'],
        'life-path-number' => ['class' => LifePathNumber::class, 'name' => 'Life Path Number'],
        'maturity-number' => ['class' => MaturityNumber::class, 'name' => 'Maturity Number'],
        'personal-day-number' => ['class' => PersonalDayNumber::class, 'name' => 'Personal Day Number'],
        'personal-month-number' => ['class' => PersonalMonthNumber::class, 'name' => 'Personal Month Number'],
        'personal-year-number' => ['class' => PersonalYearNumber::class, 'name' => 'Personal Year Number'],
        'personality-number' => ['class' => PersonalityNumber::class, 'name' => 'Personality Number'],
        'pinnacle-number' => ['class' => PinnacleNumber::class, 'name' => 'Pinnacle Number'],
        'rational-thought-number' => ['class' => RationalThoughtNumber::class, 'name' => 'Rational Thought Number'],
        'soul-urge-number' => ['class' => SoulUrgeNumber::class, 'name' => 'Soul Urge Number'],
        'subconscious-self-number' => ['class' => SubconsciousSelfNumber::class, 'name' => 'Subconscious Self Number'],
        'universal-day-number' => ['class' => UniversalDayNumber::class, 'name' => 'Universal Day Number'],
        'universal-month-number' => ['class' => UniversalMonthNumber::class, 'name' => 'Universal Month Number'],
        'universal-year-number' => ['class' => UniversalYearNumber::class, 'name' => 'Universal Year Number'],
    ],
    'chaldean' => [
        'birth-number' => ['class' => BirthNumber::class, 'name' => 'Birth Number'],
        'daily-name-number' => ['class' => DailyNameNumber::class, 'name' => 'Daily Name Number'],
        'identity-initial-code-number' => ['class' => IdentityInitialCode::class, 'name' => 'Identity Initial Code Number'],
        'life-path-number'=> ['class' => ChaldeanLifePathNumber::class, 'name' => 'Life Path Number'],
        'whole-name-number' => ['class' => WholeNameNumber::class, 'name' => 'Whole Name Number'],
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
        $calculatorName = $calculators[$system][$selectedCalculator]['name'];

        if ($selectedCalculator) {
            $calculator = new $calculators[$system][$selectedCalculator]['class']($client);
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
