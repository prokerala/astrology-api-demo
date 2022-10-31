<?php
/** @var \Prokerala\Api\Numerology\Result\PersonalYear $result */
?>
<h2 class="text-center text-black">
    <?= $result->getPersonalYearNumber()->getName() ?>
</h2>

<h3><?= $result->getPersonalYearNumber()->getName() ?> : <?= $result->getPersonalYearNumber()->getNumber() ?></h3>

<p><?= $result->getPersonalYearNumber()->getDescription() ?></p>
