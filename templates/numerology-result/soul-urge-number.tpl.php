<?php
/** @var \Prokerala\Api\Numerology\Result\SoulUrge $result */
?>
<h2 class="text-center text-black">
    <?= $result->getSoulUrgeNumber()->getName() ?>
</h2>

<h3><?= $result->getSoulUrgeNumber()->getName() ?> : <?= $result->getSoulUrgeNumber()->getNumber() ?></h3>

<p><?= $result->getSoulUrgeNumber()->getDescription() ?></p>
