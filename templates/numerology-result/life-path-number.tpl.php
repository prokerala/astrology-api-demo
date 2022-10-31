<?php
/** @var \Prokerala\Api\Numerology\Result\LifePath $result */
?>
<h2 class="text-center text-black">
    <?= $result->getLifePathNumber()->getName() ?>
</h2>

<h3><?= $result->getLifePathNumber()->getName() ?> : <?= $result->getLifePathNumber()->getNumber() ?></h3>

<p><?= $result->getLifePathNumber()->getDescription() ?></p>
