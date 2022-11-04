<?php
/** @var \Prokerala\Api\Numerology\Result\KarmicDebt $result */

// echo '<pre>' . print_r($result->getChallengeNumber(), true) . '</pre>';
// exit;
?>
<h2 class="text-center text-black">
    <?=$result->getKarmicDebtNumber()->getName()?>
</h2>

<?php foreach ($result->getKarmicDebtNumber()->getDebts() as $debt): ?>
    <h3><?= $debt->getName() ?> : <?= $debt->getNumber() ?></h3>
    <p><?= $debt->getDescription() ?></p>
<?php endforeach; ?>
