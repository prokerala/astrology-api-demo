<div class="alert alert-info text-center">
    <h3 class="my-2"><?=$numberResult['name']?> : <?=$numberResult['number'] ?? 'No Number'?></h3>
</div>
<?php if (isset($numberResult['age'])): ?>
    <p>Age: <?=$numberResult['age'];?></p>
<?php endif; ?>
<p><?=$numberResult['description']?></p>