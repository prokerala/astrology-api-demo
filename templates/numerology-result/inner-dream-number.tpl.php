<?php
/** @var \Prokerala\Api\Numerology\Result\InnerDream $result */
?>
<h2 class="text-center text-black">
    <?= $result->getInnerDreamNumber()->getName() ?>
</h2>

<h3><?= $result->getInnerDreamNumber()->getName() ?> : <?= $result->getInnerDreamNumber()->getNumber() ?></h3>

<p><?= $result->getInnerDreamNumber()->getDescription() ?></p>
