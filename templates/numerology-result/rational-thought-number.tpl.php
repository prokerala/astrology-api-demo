<?php
/** @var \Prokerala\Api\Numerology\Result\RationalThought $result */
?>
<h2 class="text-center text-black">
    <?= $result->getRationalThoughtNumber()->getName() ?>
</h2>

<h3><?= $result->getRationalThoughtNumber()->getName() ?> : <?= $result->getRationalThoughtNumber()->getNumber() ?></h3>

<p><?= $result->getRationalThoughtNumber()->getDescription() ?></p>
