<?php
/** @var \Prokerala\Api\Numerology\Result\Balance $result */
?>
<h2 class="text-center text-black">
    <?= $result->getBalanceNumber()->getName() ?>
</h2>

<h3><?= $result->getBalanceNumber()->getName() ?> : <?= $result->getBalanceNumber()->getNumber() ?></h3>

<p><?= $result->getBalanceNumber()->getDescription() ?></p>
