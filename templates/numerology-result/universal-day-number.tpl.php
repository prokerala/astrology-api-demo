<?php
/** @var \Prokerala\Api\Numerology\Result\UniversalDay $result */
?>
<h2 class="text-center text-black">
    <?= $result->getUniversalDayNumber()->getName() ?>
</h2>

<h3><?= $result->getUniversalDayNumber()->getName() ?> : <?= $result->getUniversalDayNumber()->getNumber() ?></h3>

<p><?= $result->getUniversalDayNumber()->getDescription() ?></p>
