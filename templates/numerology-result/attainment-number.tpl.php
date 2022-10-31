<?php
/** @var \Prokerala\Api\Numerology\Result\Attainment $result */
?>
<h2 class="text-center text-black">
    <?= $result->getAttainmentNumber()->getName() ?>
</h2>

<h3><?= $result->getAttainmentNumber()->getName() ?> : <?= $result->getAttainmentNumber()->getNumber() ?></h3>

<p><?= $result->getAttainmentNumber()->getDescription() ?></p>
