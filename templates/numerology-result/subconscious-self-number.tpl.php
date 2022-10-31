<?php
/** @var \Prokerala\Api\Numerology\Result\SubconsciousSelf $result */
?>
<h2 class="text-center text-black">
    <?= $result->getSubconsciousSelfNumber()->getName() ?>
</h2>

<h3><?= $result->getSubconsciousSelfNumber()->getName() ?> : <?= $result->getSubconsciousSelfNumber()->getNumber() ?></h3>

<p><?= $result->getSubconsciousSelfNumber()->getDescription() ?></p>
