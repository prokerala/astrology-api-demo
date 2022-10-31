<?php
/** @var \Prokerala\Api\Numerology\Result\BridgeNumber $result */

//echo '<pre>' . print_r($result->getChallengeNumber(), true) . '</pre>';
//exit;
?>
<h2 class="text-center text-black">
    <?=$result->getBridgeNumber()->getName()?>
</h2>

<?php foreach ($result->getBridgeNumber()->getDifferences() as $challenge): ?>
    <h3><?= $challenge->getName() ?> : <?= $challenge->getNumber() ?></h3>
    <p><?= $challenge->getDescription() ?></p>
<?php endforeach; ?>
