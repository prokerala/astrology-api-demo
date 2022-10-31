<?php
/** @var \Prokerala\Api\Numerology\Result\KarmicDebt $result */

//echo '<pre>' . print_r($result->getChallengeNumber(), true) . '</pre>';
//exit;
?>
<h2 class="text-center text-black">
    <?=$result->getKarmicDebtNumber()->getName()?>
</h2>

<?php foreach ($result->getKarmicDebtNumber()->getDebts() as $challenge): ?>
    <h3><?= $challenge->getName() ?> : <?= $challenge->getNumber() ?></h3>
    <p><?= $challenge->getDescription() ?></p>
<?php endforeach; ?>
