<?php
/** @var \Prokerala\Api\Numerology\Result\Destiny $result */
?>
<h2 class="text-center text-black">
    <?= $result->getDestinyNumber()->getName() ?>
</h2>

<h3><?= $result->getDestinyNumber()->getName() ?> : <?= $result->getDestinyNumber()->getNumber() ?></h3>

<p><?= $result->getDestinyNumber()->getDescription() ?></p>
