<h3><?=$numberResult['name']?> : <?=$numberResult['number'] ?? 'No Number'?></h3>
<?php if (isset($numberResult['age'])): ?>
    <p>Age: <?=$numberResult['age'];?></p>
<?php endif; ?>
<p><?=$numberResult['description']?></p>