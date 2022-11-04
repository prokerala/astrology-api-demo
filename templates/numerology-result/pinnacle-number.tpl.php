<?php
/** @var \Prokerala\Api\Numerology\Result\Pinnacle $result */

// echo '<pre>' . print_r($result->getChallengeNumber(), true) . '</pre>';
// exit;
?>
<h2 class="text-center text-black">
    <?=$result->getPinnacleNumber()->getName()?>
</h2>

<?php foreach ($result->getPinnacleNumber()->getPinnacles() as $pinnacle): ?>
    <h3><?= $pinnacle->getName() ?> : <?= $pinnacle->getNumber() ?></h3>
    <p>Age:<?= $pinnacle->getAge() ?></p>
    <p><?= $pinnacle->getDescription() ?></p>
<?php endforeach; ?>
