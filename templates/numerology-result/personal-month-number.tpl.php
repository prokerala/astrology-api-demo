<?php
/** @var \Prokerala\Api\Numerology\Result\PersonalMonth $result */
?>
<h2 class="text-center text-black">
    <?= $result->getPersonalMonthNumber()->getName() ?>
</h2>

<h3><?= $result->getPersonalMonthNumber()->getName() ?> : <?= $result->getPersonalMonthNumber()->getNumber() ?></h3>

<p><?= $result->getPersonalMonthNumber()->getDescription() ?></p>
