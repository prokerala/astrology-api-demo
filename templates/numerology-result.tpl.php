<?php
//echo '<pre>'. print_r($result->getSubconsciousSelfNumber(), true) .'</pre>';
//exit;
$numberResultObject = null;
$numberResult = null;
$nameChart = null;
$multipleAgeNumberResult = false;
$multipleNumberResult = false;

if ($system === 'pythagorean') {

    if ($selectedCalculator === 'life-path-number') {
        $numberResultObject = $result->getLifePathNumber();
    } else if ($selectedCalculator === 'personality-number') {
        $numberResultObject = $result->getPersonalityNumber();
    } else if ($selectedCalculator === 'personal-year-number') {
        $numberResultObject = $result->getPersonalYearNumber();
    } else if ($selectedCalculator === 'universal-month-number') {
        $numberResultObject = $result->getUniversalMonthNumber();
    } else if ($selectedCalculator === 'personal-day-number') {
        $numberResultObject = $result->getPersonalDayNumber();
    } else if ($selectedCalculator === 'personal-month-number') {
        $numberResultObject = $result->getPersonalMonthNumber();
    } else if ($selectedCalculator === 'birthday-number') {
        $numberResultObject = $result->getBirthdayNumber();
    } else if ($selectedCalculator === 'birth-month-number') {
        $numberResultObject = $result->getBirthMonthNumber();
    } else if ($selectedCalculator === 'universal-day-number') {
        $numberResultObject = $result->getUniversalDayNumber();
    } else if ($selectedCalculator === 'universal-year-number') {
        $numberResultObject = $result->getUniversalYearNumber();
    } else if ($selectedCalculator === 'inner-dream-number') {
        $numberResultObject = $result->getInnerDreamNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'attainment-number') {
        $numberResultObject = $result->getAttainmentNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'expression-number') {
        $numberResultObject = $result->getExpressionNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'soul-urge-number') {
        $numberResultObject = $result->getSoulUrgeNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'balance-number') {
        $numberResultObject = $result->getBalanceNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'destiny-number') {
        $numberResultObject = $result->getDestinyNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'capstone-number') {
        $numberResultObject = $result->getCapstoneNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'cornerstone-number') {
        $numberResultObject = $result->getCornerstoneNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'subconscious-self-number') {
        $numberResultObject = $result->getSubconsciousSelfNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'maturity-number') {
        $numberResultObject = $result->getMaturityNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'hidden-passion-number') {
        $numberResultObject = $result->getHiddenPassionNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'rational-thought-number') {
        $numberResultObject = $result->getRationalThoughtNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'challenge-number') {
        $name = $result->getChallengeNumber()->getName();
        $multipleAgeNumbers = $result->getChallengeNumber()->getChallenges();
        $multipleAgeNumberResult = true;
    } else if ($selectedCalculator === 'pinnacle-number') {
        $name = $result->getPinnacleNumber()->getName();
        $multipleAgeNumbers = $result->getPinnacleNumber()->getPinnacles();
        $multipleAgeNumberResult = true;
    } else if ($selectedCalculator === 'karmic-debt-number') {
        $name = $result->getKarmicDebtNumber()->getName();
        $multipleNumbers = $result->getKarmicDebtNumber()->getDebts();
        $multipleNumberResult = true;
    } else if ($selectedCalculator === 'bridge-number') {
        $name = $result->getBridgeNumber()->getName();
        $multipleNumbers = $result->getBridgeNumber()->getDifferences();
        $multipleNumberResult = true;
    }
} else {
    if ($selectedCalculator === 'birth-number') {
        $numberResultObject = $result->getBirthNumber();
    } else if ($selectedCalculator === 'life-path-number') {
        $numberResultObject = $result->getLifePathNumber();
    } else if ($selectedCalculator === 'identity-initial-code-number') {
        $numberResultObject = $result->getIdentityInitialCodeNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'daily-name-number') {
        $numberResultObject = $result->getDailyNameNumber();
        $nameChart = $result->getNameChart();
    } else if ($selectedCalculator === 'whole-name-number') {
        $name = $result->getWholeNameNumber()->getName();
        $multipleNumbers = $result->getWholeNameNumber()->getEnergies();
        $multipleNumberResult = true;
        $nameChart = $result->getNameChart();
    }
}

if ($numberResultObject) {
    $numberResult = [
        'name' => $numberResultObject->getName(),
        'number' => $numberResultObject->getNumber(),
        'description' => $numberResultObject->getDescription(),
    ];
}

?>


<?php if ($numberResult): ?>
    <?php include 'numerology-number-result-only.tpl.php'; ?>
<?php endif; ?>

<?php if ($multipleAgeNumberResult): ?>
    <h3 class="text-dark"><?=$name?></h3>
    <?php foreach ($multipleAgeNumbers as $number): ?>
        <?php
            $numberResult = [
                'name' => $number->getName(),
                'age' => $number->getAge(),
                'number' => $number->getNumber(),
                'description' => $number->getDescription(),
            ];
        ?>
        <?php include 'numerology-number-result-only.tpl.php'; ?>
    <?php endforeach; ?>
<?php endif; ?>


<?php if ($multipleNumberResult): ?>
    <h3 class="text-dark"><?=$name?></h3>
    <?php foreach ($multipleNumbers as $number): ?>
        <?php
        $numberResult = [
            'name' => $number->getName(),
            'number' => $number->getNumber(),
            'description' => $number->getDescription(),
        ];
        ?>
        <?php include 'numerology-number-result-only.tpl.php'; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($nameChart): ?>
    <?php include 'numerology-name-chart-only.tpl.php'; ?>
<?php endif; ?>