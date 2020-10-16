<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kundli | Prokerala API</title>

    <link rel="stylesheet" href="/build/style.css">

</head>

<body>
<?php include 'common/header.tpl.php'; ?>

<div class="main-content demo-container">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Kundli</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($result)): ?>

            <?php $nakshatra_details = $kundliResult['nakshatraDetails']; ?>
            <table class="table table-bordered mb-5">
                <?php foreach ($kundliResult['nakshatraDetails'] as $key => $kundli):?>
                    <?php if(in_array( $key, ['nakshatra', 'chandraRasi', 'sooryaRasi'])):?>
                        <?php $item = preg_replace('/(?<!\ )[A-Z]/', ' $0', $key);?>
                        <tr><th><?=ucwords($item)?></th><td><?=$kundli['name']?></td></tr>
                        <tr><th><?=ucwords($item)?> Lord</th><td><?="{$kundli['lord']['vedicName']} ({$kundli['lord']['name']})"?></td></tr>
                    <?php elseif($key === 'additionalInfo'):?>
                        <tr class="text-center"><th class="table-warning" colspan=2">Additional Info</th></tr>
                        <?php foreach($kundli as $index => $value):?>
                            <tr><th><?=ucwords(preg_replace('/(?<!\ )[A-Z]/', ' $0', $index))?></th><td><?=$value?></td></tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><th><?=ucwords($item)?></th><td><?=$kundli['name']?></td></tr>
                    <?php endif;?>
                <?php endforeach;?>
            </table>

            <h3 class="text-black">Yoga Details</h3>
            <?php foreach ($kundliResult['yogaDetails'] as $data):?>
                <span class="font-weight-regular text-black"><?= ($data['name'])?></span>
                <p class="text-black"><?=$data['description']?></p>
            <?php endforeach; ?>
            <div class="alert p-4 text-center p-5 <?=$kundliResult['mangalDosha']['hasDosha'] ? 'alert-danger' : 'alert-success'?>" >
                <?=$kundliResult['mangalDosha']['description']?>
            </div>

        <?php elseif (!empty($errors)):?>
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


    </div>
</div>


<?php include 'common/footer.tpl.php'; ?>

</body>
</html>
