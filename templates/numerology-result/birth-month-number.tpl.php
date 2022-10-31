<?php
/** @var \Prokerala\Api\Numerology\Result\BirthMonth $result */
?>
<h2 class="text-center text-black">
    <?= $result->getBirthMonthNumber()->getName() ?>
</h2>

<h3><?= $result->getBirthMonthNumber()->getName() ?> : <?= $result->getBirthMonthNumber()->getNumber() ?></h3>

<p><?= $result->getBirthMonthNumber()->getDescription() ?></p>
