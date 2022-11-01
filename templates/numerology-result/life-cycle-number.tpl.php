<?php
/** @var \Prokerala\Api\Numerology\Result\LifeCycleNumber $result */

//echo '<pre>' . print_r($result->getChallengeNumber(), true) . '</pre>';
//exit;
?>
<h2 class="text-center text-black">
    <?=$result->getLifeCycle()->getName()?>
</h2>

<?php foreach ($result->getLifeCycleNumber()->getCycles() as $cycle): ?>
    <h3><?= $cycle->getName() ?> : <?= $cycle->getNumber() ?></h3>
    <p><?= $cycle->getDescription() ?></p>
<?php endforeach; ?>
