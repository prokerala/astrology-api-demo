<?php
/** @var \Prokerala\Api\Numerology\Result\Maturity $result */
?>
<h2 class="text-center text-black">
    <?= $result->getMaturityNumber()->getName() ?>
</h2>

<h3><?= $result->getMaturityNumber()->getName() ?> : <?= $result->getMaturityNumber()->getNumber() ?></h3>

<p><?= $result->getMaturityNumber()->getDescription() ?></p>
