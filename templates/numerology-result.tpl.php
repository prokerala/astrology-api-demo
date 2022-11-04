<?php
$numberResultObject = null;
$numberResult = null;
$nameChart = null;
$multipleAgeNumberResult = false;
if ($selectedCalculator === 'life-path-number') {
    $numberResultObject = $result->getLifePathNumber();
} else if ($selectedCalculator === 'capstone-number') {
    $numberResultObject = $result->getCapstoneNumber();
    $nameChart = $result->getNameChart();
} else if ($selectedCalculator === 'challenge-number') {
    $name = $result->getChallengeNumber()->getName();
    $multipleNumbers = $result->getChallengeNumber()->getChallenges();
    $multipleAgeNumberResult = true;
}

if ($numberResultObject) {
    $numberResult = [
        'name' => $numberResultObject->getName(),
        'number' => $numberResultObject->getNumber(),
        'description' => $numberResultObject->getDescription(),
    ];
}

?>

<?php if ($nameChart): ?>
    <?php include 'numerology-name-chart-only.tpl.php'; ?>
<?php endif; ?>

<?php if ($numberResult): ?>
    <?php include 'numerology-number-result-only.tpl.php'; ?>
<?php endif; ?>

<?php if ($multipleAgeNumberResult): ?>
    <h3><?=$name?></h3>
    <?php foreach ($multipleNumbers as $number): ?>
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
