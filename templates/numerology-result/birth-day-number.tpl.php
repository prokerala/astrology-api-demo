<?php
/** @var \Prokerala\Api\Numerology\Result\Birthday $result */
?>
<h2 class="text-center text-black">
    <?= $result->getBirthdayNumber()->getName() ?>
</h2>

<h3><?= $result->getBirthdayNumber()->getName() ?> : <?= $result->getBirthdayNumber()->getNumber() ?></h3>

<p><?= $result->getBirthdayNumber()->getDescription() ?></p>
