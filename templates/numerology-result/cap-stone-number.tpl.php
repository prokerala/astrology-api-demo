<?php
/** @var \Prokerala\Api\Numerology\Result\CapStone $result */
?>
<h2 class="text-center text-black">
    <?= $result->getCapStoneNumber()->getName() ?>
</h2>

<h3><?= $result->getCapStoneNumber()->getName() ?> : <?= $result->getCapStoneNumber()->getNumber() ?></h3>

<p><?= $result->getCapStoneNumber()->getDescription() ?></p>
