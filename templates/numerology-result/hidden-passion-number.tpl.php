<?php
/** @var \Prokerala\Api\Numerology\Result\HiddenPassion $result */
?>
<h2 class="text-center text-black">
    <?= $result->getHiddenPassionNumber()->getName() ?>
</h2>

<h3><?= $result->getHiddenPassionNumber()->getName() ?> : <?= $result->getHiddenPassionNumber()->getNumber() ?></h3>

<p><?= $result->getHiddenPassionNumber()->getDescription() ?></p>
