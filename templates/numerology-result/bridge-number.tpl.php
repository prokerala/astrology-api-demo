<?php
/** @var \Prokerala\Api\Numerology\Result\BridgeNumber $result */

// echo '<pre>' . print_r($result->getChallengeNumber(), true) . '</pre>';
// exit;
?>
<h2 class="text-center text-black">
    <?=$result->getBridgeNumber()->getName()?>
</h2>

<?php foreach ($result->getBridgeNumber()->getDifferences() as $difference): ?>
    <h3><?= $difference->getName() ?> : <?= $difference->getNumber() ?></h3>
    <p><?= $difference->getDescription() ?></p>
<?php endforeach; ?>
