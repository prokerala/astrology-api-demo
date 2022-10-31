<?php
/** @var \Prokerala\Api\Numerology\Result\UniversalMonth $result */
?>
<h2 class="text-center text-black">
    <?= $result->getUniversalMonthNumber()->getName() ?>
</h2>

<h3><?= $result->getUniversalMonthNumber()->getName() ?> : <?= $result->getUniversalMonthNumber()->getNumber() ?></h3>

<p><?= $result->getUniversalMonthNumber()->getDescription() ?></p>
