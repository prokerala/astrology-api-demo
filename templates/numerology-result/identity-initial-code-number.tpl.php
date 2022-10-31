<?php
/** @var \Prokerala\Api\Numerology\Result\Chaldean\IdentityInitialCode $result */
?>
<h2 class="text-center text-black">
    <?= $result->getIdentityInitialCodeNumber()->getName() ?>
</h2>

<h3><?= $result->getIdentityInitialCodeNumber()->getName() ?> : <?= $result->getIdentityInitialCodeNumber()->getNumber() ?></h3>

<p><?= $result->getIdentityInitialCodeNumber()->getDescription() ?></p>
