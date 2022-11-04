<?php
/** @var \Prokerala\Api\Numerology\Result\Chaldean\WholeNameNumber $result */

// echo '<pre>' . print_r($result->getChallengeNumber(), true) . '</pre>';
// exit;
?>
<h2 class="text-center text-black">
    <?=$result->getWholeNameNumber()->getName()?>
</h2>

<?php foreach ($result->getWholeNameNumber()->getEnergies() as $energy): ?>
    <h3><?= $energy->getName() ?> : <?= $energy->getNumber() ?></h3>
    <p><?= $energy->getDescription() ?></p>
<?php endforeach; ?>
