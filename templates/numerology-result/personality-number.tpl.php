<?php
/** @var \Prokerala\Api\Numerology\Result\Personality $result */
?>
<h2 class="text-center text-black">
    <?= $result->getPersonalityNumber()->getName() ?>
</h2>

<h3><?= $result->getPersonalityNumber()->getName() ?> : <?= $result->getPersonalityNumber()->getNumber() ?></h3>

<p><?= $result->getPersonalityNumber()->getDescription() ?></p>
