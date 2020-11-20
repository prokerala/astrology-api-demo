<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Porutham & Marriage Matching | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">
</head>

<body>
<?php include 'common/header.tpl.php'; ?>
<?php $alertClass = [
    'Excellent' => 'alert-success',
    'Good' => 'alert-info',
    'Average' => 'alert-warning',
    'Bad' => 'alert-danger',
]; ?>
<div class="main-content">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet bg-container section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Porutham</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <h3>Birth Details</h3>
            <table class="table table-bordered  mb-5 table-hover">
                <tr class="bg-secondary text-white text-center">
                    <th>#</th>
                    <th>Details of Girl</th>
                    <th>Details of Boy</th>
                </tr>
                <tr>
                    <th>Date Of Birth</th>
                    <td><?=$girl_dob->format('F d, Y')?></td>
                    <td><?=$boy_dob->format('F d, Y')?></td>
                </tr>
                <?php foreach ($compatibilityResult['girlInfo'] as $idx => $info): ?>
                    <?php if (in_array($idx, ['nakshatra', 'rasi'], true)):?>
                        <?php foreach ($info as $item => $itemVale):?>
                            <?php if ('id' === $item) {
    continue;
}?>
                            <?php if ('lord' === $item):?>
                                <tr>
                                    <td><b><?=$item?></b></td>
                                    <td><?="{$itemVale['vedicName']} ({$itemVale['name']})"?></td>
                                    <td><?="{$compatibilityResult['boyInfo'][$idx][$item]['vedicName']} ({$compatibilityResult['boyInfo'][$idx][$item]['name']})"?></td>
                                </tr>
                            <?php else:?>
                                <tr>
                                <td><b><?=$item?></b></td>
                                <td><?=$itemVale?></td>
                                <td><?=$compatibilityResult['boyInfo'][$idx][$item]?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
            <div class="alert alert-info mb-5 p-4 text-center <?=$alertClass[$compatibilityResult['message']['type']]?>">
                <?=$compatibilityResult['message']['description']?> (<?=$compatibilityResult['totalPoints']?> / 10)
            </div>
            <h3 class="text-black text-center">10 Poruthams and Your Compatibility</h3>
            <table class="mb-5 table table-bordered table-hover">
                <tr class="bg-secondary text-white text-center">
                    <th>#</th>
                    <th>Porutham</th>
                    <?php if ('advanced' === $result_type): ?>
                        <th>Status</th>
                    <?php endif; ?>
                    <th class="text-center">Obtained Point</th>
                </tr>
                <?php foreach ($compatibilityResult['matches'] as $idx => $data):?>
                    <tr><td><?=$idx + 1?></td><td><?=$data['name']?></td>
                        <?php if ('advanced' === $result_type):?>
                            <td>
                                <?='Good' === $data['poruthamStatus'] ? '<span class="text-success">Good</span>' :
                                    ('Satisfactory' === $data['poruthamStatus'] ? '<span class="text-warning">Satisfactory</span>' :
                                        '<span class="text-danger">Not Satisfactory</span>')?></td>
                            <td class="text-center"><?=$data['points']?></td>
                        <?php else:?>
                            <td class="text-center"><?=$data['hasPorutham'] ? 1 : 0?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <tr class="text-center text-large">
                    <th colspan="<?='advanced' === $result_type ? 3 : 2?>">Total Points:</th>
                    <th><?=$compatibilityResult['totalPoints']?> / <?=$compatibilityResult['maximumPoints']?></th>
                </tr>
            </table>

            <?php if ('advanced' === $result_type):?>
                <h3>Interpretation of 10 porutham</h3>
                <?php foreach ($compatibilityResult['matches'] as $key => $data):?>
                    <h3><?=$data['name']?></h3>
                    <p><?=$data['description']?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
        <section>

            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="porutham.php" method="POST">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 pr-md-0 col-form-label">Ayanamsa</label>
                                <div class="col-md-8 pl-md-0">
                                    <select name="ayanamsa" class="form-control form-control-lg rounded-1">
                                        <option value="1" <?=1 == $ayanamsa ? 'selected' : ''?>>Lahiri</option>
                                        <option value="3" <?=3 == $ayanamsa ? 'selected' : ''?>>Raman</option>
                                        <option value="5" <?=5 == $ayanamsa ? 'selected' : ''?>>KP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 pr-md-0 col-form-label">System</label>
                                <div class="col-md-8 pl-md-0">
                                    <select name="system" class="form-control form-control-lg rounded-1">
                                        <option value="kerala" <?='kerala' === $system ? 'selected' : ''?>>Kerala</option>
                                        <option value="tamil" <?='tamil' === $system ? 'selected' : ''?>>Tamil</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'common/porutham-form.tpl.php'; ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-xs-left">Result Type: </label>
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
