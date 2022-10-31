<?php
/** @var \Prokerala\Api\Numerology\Result\Challenge $result */

//echo '<pre>' . print_r($result->getChallengeNumber(), true) . '</pre>';
//exit;
?>
<h2 class="text-center text-black">
    <?=$result->getChallengeNumber()->getName()?>
</h2>

<?php foreach ($result->getChallengeNumber()->getChallenges() as $challenge): ?>
    <h3><?= $challenge->getName() ?> : <?= $challenge->getNumber() ?></h3>
    <p>Age:<?= $challenge->getAge() ?></p>
    <p><?= $challenge->getDescription() ?></p>
<?php endforeach; ?>
