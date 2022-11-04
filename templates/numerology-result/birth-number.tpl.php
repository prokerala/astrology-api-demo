<?php
/** @var \Prokerala\Api\Numerology\Result\Chaldean\Birth $result */
?>

<h2 class="text-center text-black">
    <?= $result->getBirthNumber()->getName() ?>
</h2>

<h3><?= $result->getBirthNumber()->getName() ?> : <?= $result->getBirthNumber()->getNumber() ?></h3>

<p><?= $result->getBirthNumber()->getDescription() ?></p>
