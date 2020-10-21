<div class="text-center">
    <a href="https://github.com/prokerala/astrology-api-demo/blob/master/public/<?=$sample_name?>.php" class="btn btn-primary btn-sm mb-3" role="button">Get Code</a>
    <a href="/docs#operation/get-<?=$samples[$sample_name]['docs']?><?= isset($advanced) ? '-advanced' :''?>" class="btn btn-primary btn-sm mb-3" role="button">Documentation</a>
</div>
<section>
    <div class=" text-center">
        <div class="features-icon-list mb-5 container">
            <h2 class="text-black mb-5">
                <span class="font-weight-thin">Other Calculators</span>
            </h2>
            <div class="card-list-wrapper">
                <div class="row list-element-grid">
                    <?php foreach ($samples as $value):?>
                        <div class="col-md-2 mb-5 px-3">
                            <a href="<?=$value['url']?>">
                                <span class="feature-card-image"><img src="<?=$value['image']?>"></span>
                                <span class="feature-card-title"><?=$value['title']?></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
