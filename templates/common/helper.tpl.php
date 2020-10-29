
<?php if($apiCreditUsed):?>
    <div class="mb-4">
        <span class="bg-success text-white btn-sm p-3">
            Credit Used <span class="badge badge-light"><?=$apiCreditUsed?></span>
        </span>
    </div>
<?php endif;?>

<?php if (!empty($errors)):?>
    <?php foreach ($errors as $key => $error):?>
        <div class="alert alert-danger text-small">
            <?php if ('message' === $key):?>
                <?=$error?>
            <?php else:?>
                <?=$error->title ?? ''; ?>:
                <?=$error->detail ?? ''?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif;?>
