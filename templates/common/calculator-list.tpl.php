<div class="text-center">
    <a href="https://github.com/prokerala/astrology-api-demo/blob/master/public/<?=$sample_name?>.php" class="btn btn-primary btn-sm mb-3" role="button">View Source Code</a>
    <a href="/docs#operation/get-<?=$samples[$sample_name]['docs']?><?= isset($advanced) ? '-advanced' : ''?>" class="btn btn-primary btn-sm mb-3" role="button">Documentation</a>
</div>

<?php if(in_array($sample_name, $westernSamples)): ?>
    <?php $samples = array_filter($samples, fn($val) => in_array($val['docs'], $westernSamples)); ?>
<?php else:?>
    <?php $samples = array_filter($samples, fn($val) => !in_array($val['docs'], $westernSamples)); ?>
<?php endif;?>

<section>
    <div class=" text-center">
        <div class="features-icon-list mb-5 container">
            <h2 class="text-black mb-5">
                <span class="font-weight-thin">Other <?=in_array($sample_name, $westernSamples) ? 'Western ' : ''?>Calculators</span>
            </h2>
            <div class="row">
                <?php foreach ($samples as $value):?>
                    <div class="col-4 col-sm-3 col-md-2 col-lg-1 mb-5">
                        <a href="<?=$value['url']?>">
                            <span class="demo-feature-card-image feature-card-image"><img src="<?=DEMO_BASE_URL?><?=$value['image']?>"></span>
                            <div class="feature-card-title b" style="font-size: 1.5rem;"><?=$value['title']?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
