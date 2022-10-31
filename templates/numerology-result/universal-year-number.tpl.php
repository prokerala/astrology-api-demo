<?php
/** @var \Prokerala\Api\Numerology\Result\UniversalYear $result */
?>
<h2 class="text-center text-black">
    <?= $result->getUniversalYearNumber()->getName() ?>
</h2>

<h3><?= $result->getUniversalYearNumber()->getName() ?> : <?= $result->getUniversalYearNumber()->getNumber() ?></h3>

<p><?= $result->getUniversalYearNumber()->getDescription() ?></p>
