<?php
/** @var \Prokerala\Api\Numerology\Result\Expression $result */
?>
<h2 class="text-center text-black">
    <?= $result->getExpressionNumber()->getName() ?>
</h2>

<h3><?= $result->getExpressionNumber()->getName() ?> : <?= $result->getExpressionNumber()->getNumber() ?></h3>

<p><?= $result->getExpressionNumber()->getDescription() ?></p>
