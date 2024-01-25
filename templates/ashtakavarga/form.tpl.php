<?php
declare(strict_types=1);

/**
 * @var string $chart_style
 */
use Prokerala\Api\Astrology\Result\Planet;
?>

<section>
    <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
        <form class="p-5 text-default"  action="ashtakavarga.php" method="POST">
            <?php include __DIR__ . '/../common/panchang-form.tpl.php'; ?>
            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Planet</label>
                <div class="col-sm-9 col-md-6">
                    <select name="planet" class="form-control form-control-lg rounded-1">

                        <?php foreach (Planet::PLANET_LIST as $planet_id => $planet_name): ?>

                            <?php if ($planet_id > Planet::SATURN) {
                                continue;
                            } ?>
                            <option value="<?=$planet_id?>" <?=0 === $planet_id ? 'selected' : ''?>><?=$planet_name?></option>

                        <?php endforeach; ?>

                        <option value="sarvashtakavarga">Sarvashtakavarga</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Chart Style</label>
                <div class="col-sm-9 col-md-6">
                    <select name="chart_style" class="form-control form-control-lg rounded-1">
                        <option value="south-indian" <?='south-indian' === $chart_style ? 'selected' : ''?>>South Indian</option>
                        <option value="north-indian" <?='north-indian' === $chart_style ? 'selected' : ''?>>North Indian</option>
                        <option value="east-indian" <?='east-indian' === $chart_style ? 'selected' : ''?>>East Indian</option>
                    </select>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-warning btn-submit ">Get Result</button>
                <input type="hidden" name="submit" value="1">
            </div>
        </form>
    </div>
</section>
