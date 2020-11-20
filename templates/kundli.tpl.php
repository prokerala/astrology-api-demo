<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kundli | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">
    <style>
        .table-dashas{
            max-width:100%;
        }
        @media (min-width: 576px) {
            .table-dashas{
                margin:.5%;
                max-width:49%;
            }
        }

    </style>

</head>

<body>
<?php include 'common/header.tpl.php'; ?>

<div class="main-content">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet bg-container section-radius-min">
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

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>

            <?php $nakshatra_details = $kundliResult['nakshatraDetails']; ?>
            <table class="table table-bordered mb-5 table-hover">
                <tr class="bg-secondary text-white text-center"><th colspan=2">Nakshatra Details</th></tr>
                <?php foreach ($kundliResult['nakshatraDetails'] as $key => $kundli):?>
                    <?php $item = preg_replace('/(?<!\ )[A-Z]/', ' $0', $key); ?>
                    <?php if (in_array($key, ['nakshatra', 'chandraRasi', 'sooryaRasi'])):?>
                        <tr><th><?=ucwords($item)?></th><td><?=$kundli['name']?></td></tr>
                        <tr><th><?=ucwords($item)?> Lord</th><td><?="{$kundli['lord']['vedicName']} ({$kundli['lord']['name']})"?></td></tr>
                    <?php elseif ('additionalInfo' === $key):?>
                        <tr class="bg-secondary text-white text-center"><th colspan=2">Additional Info</th></tr>
                        <?php foreach ($kundli as $index => $value):?>
                            <tr><th><?=ucwords(preg_replace('/(?<!\ )[A-Z]/', ' $0', $index))?></th><td><?=$value?></td></tr>
                        <?php endforeach; ?>
                    <?php else:?>
                        <tr><th><?=ucwords($item)?></th><td><?=$kundli['name']?></td></tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>

            <h3 class="text-black">Yoga Details</h3>
            <?php foreach ($kundliResult['yogaDetails'] as $data):?>
                <h3 class="font-weight-regular text-black"><?= ($data['name'])?></h3>
                <p class="text-black"><?=$data['description']?></p>
                <?php if ('advanced' === $result_type):?>
                    <?php foreach ($data['yogaList'] as $yogas):?>
                        <?php if ($yogas['hasYoga']):?>
                        <span class="font-weight-regular text-black"><?=$yogas['name']?></span>
                        <p class="text-black"><?=$yogas['description']?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="alert p-4 text-center p-5 <?=$kundliResult['mangalDosha']['hasDosha'] ? 'alert-danger' : 'alert-success'?>" >
                <?=$kundliResult['mangalDosha']['description']?>
            </div>
            <?php if ('advanced' === $result_type):?>
                <?php if ($kundliResult['mangalDosha']['hasException']):?>
                    <h3>Exceptions</h3>
                    <ul>
                        <?php foreach ($kundliResult['mangalDosha']['exceptions'] as $exceptions):?>
                            <li><?=$exceptions?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>


                <?php foreach ($kundliResult['dashaPeriods'] as $mahadashas):?>
                    <h3 class="text-black">Anthardashas in <?=$mahadashas['name']?> Mahadasha</h3>
                    <div class="row">
                    <?php foreach ($mahadashas['antardasha'] as $anthardashas):?>
                        <table class="table table-bordered mb-5 col-12 col-md-6 text-small table-dashas">
                            <tr><th>AD</th><th>PD</th><th>Starts</th><th>Ends</th></tr>
                        <?php foreach ($anthardashas['pratyantardasha'] as $paryantradashas):?>
                        <tr>
                            <td><?=$anthardashas['name']?></td>
                            <td><?=$paryantradashas['name']?></td>
                            <td><?=$paryantradashas['start']->format('d-m-Y')?></td>
                            <td><?=$paryantradashas['end']->format('d-m-Y')?></td>
                        </tr>
                        <?php endforeach; ?>
                        </table>
                    <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <p class="text-small text-right text-danger"><span class="text-danger">**</span> AD stands for Antardasha &  PD stands for Paryantra dasha</p>

            <?php endif; ?>
        <?php endif; ?>
        <section>
            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="" method="POST">
                    <?php include 'common/horoscope-form.tpl.php'; ?>
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
                        <button type="submit" class="btn btn-warning btn-submit">Get Result</button>
                        <input type="hidden" name="submit" value="1">
                    </div>
                </form>
            </div>
        </section>
        <?php include 'common/calculator-list.tpl.php'; ?>


    </div>
</div>


<?php include 'common/footer.tpl.php'; ?>

<!-- CODE FOR LOCATION SEARCH STARTS -->
<script src="https://client-api.prokerala.com/static/js/location.min.js"></script>
<script>
    (function () {
        let location = document.querySelectorAll('.prokerala-location-input');
        [...location].map(function (input) {
            new LocationSearch(input, function (data) {
                const inputPrefix = input.dataset.location_input_prefix ? input.dataset.location_input_prefix : '';
                const hiddenDiv = document.getElementById('form-hidden-fields');
                const coordinates = document.createElement('input');
                coordinates.name = inputPrefix +'coordinates';
                coordinates.type = 'hidden';
                coordinates.value = `${data.latitude},${data.longitude}`;
                const timezone = document.createElement('input');
                timezone.name = inputPrefix +'timezone';
                timezone.type = 'hidden';
                timezone.value = data.timezone;
                hiddenDiv.appendChild(coordinates);
                hiddenDiv.appendChild(timezone);
            }, {clientId: CLIENT_ID});
        });
    })();
</script>
<!-- CODE FOR LOCATION SEARCH ENDS -->
</body>
</html>
