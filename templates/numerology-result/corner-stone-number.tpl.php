<?php
/** @var \Prokerala\Api\Numerology\Result\CornerStone $result */
?>
<h2 class="text-center text-black">
    <?= $result->getCornerStoneNumber()->getName() ?>
</h2>

<h3><?= $result->getCornerStoneNumber()->getName() ?> : <?= $result->getCornerStoneNumber()->getNumber() ?></h3>

<p><?= $result->getCornerStoneNumber()->getDescription() ?></p>
