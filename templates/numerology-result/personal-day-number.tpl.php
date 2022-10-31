<?php
/** @var \Prokerala\Api\Numerology\Result\PersonalDay $result */
?>
<h2 class="text-center text-black">
    <?= $result->getPersonalDayNumber()->getName() ?>
</h2>

<h3><?= $result->getPersonalDayNumber()->getName() ?> : <?= $result->getPersonalDayNumber()->getNumber() ?></h3>

<p><?= $result->getPersonalDayNumber()->getDescription() ?></p>
