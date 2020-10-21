<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sade Sati | Astrology API Demo - Prokerala Astrology</title>

    <link rel="stylesheet" href="/build/style.css">

</head>

<body>
<?php include 'common/header.tpl.php'; ?>

<div class="main-content">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Sade Sati</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container demo-container">
        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>
            <div class="alert text-center p-4 pad-large <?=(($sadeSatiResult['isInSadeSati']) ? 'alert-danger' : 'alert-success')?>">
                <?=$sadeSatiResult['description']?>
            </div>
            <?php if ('advanced' === $result_type):?>
                <h3 class="text-black">The Detailed sade sati report is as follows</h3>
                <table class="table table-bordered mb-5 text-small">
                    <tr>
                        <th>Sade Sati Phase</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                    <?php foreach ($sadeSatiResult['transits'] as $transit):?>
                        <tr><td><?=$transit['phase']?></td>
                            <td><?=$transit['start']->format('F d, Y')?></td>
                            <td><?=$transit['end']->format('F d, Y')?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        <?php endif; ?>
        <section>

            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="" method="POST">
                    <?php include 'common/basic-form.tpl.php'; ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Result Type: </label>
                        <div class="col-sm-9 col-md-6 ">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="result_type" id="result_type1" value="basic" <?='basic' === $result_type ? 'checked' : ''?>>
                                <label class="form-check-label" for="result_type1">Basic</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="result_type" id="result_type2" value="advanced" <?='advanced' === $result_type ? 'checked' : ''?>>
                                <label class="form-check-label" for="result_type2">Advanced</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-warning">Get Result</button>
                        <input type="hidden" name="submit" value="1">
                    </div>
                </form>
            </div>
        </section>
        <?php include 'common/calculator-list.tpl.php'; ?>

    </div>
</div>


<?php include 'common/footer.tpl.php'; ?>

</body>
</html>
