<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Papa Samyam Check | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">

</head>

<body>
<?php include 'common/header.tpl.php'; ?>

<div class="main-content">
    <div class="header-1 mb-0 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet bg-container section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Papasamyam Check</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <?php $arPapaPlanets = ['Mars', 'Saturn', 'Sun', 'Rahu']; ?>
            <?php $arPapaFromPlanets = ['Ascendant', 'Moon', 'Venus']; ?>
            <h2 class="text-center text-black">Papasamyam Details</h2>
            <h3 class="text-black">Girl Papa Points</h3>
            <table class="table table-bordered table-responsive-sm table-hover">
                <thead class="bg-secondary text-white">
                <tr><th rowspan="2">Girl Papa Points</th><th colspan="2">From Ascendant</th>
                    <th colspan="2">From Moon</th><th colspan="2">From Venus</th>
                </tr>
                <tr><th>Position</th><th>Papam</th><th>Position</th>
                    <th>Papam</th><th>Position</th><th>Papam</th>
                </tr>
                </thead>
                    <?php foreach ($arPapaPlanets as $papaPlanet => $papaPlanetName):?>
                        <tr><th><?=$papaPlanetName?></th>
                        <?php foreach ($arPapaFromPlanets as $fromPlanet => $fromPlanetName):?>
                            <td><?=$papaSamyamCheckResult['girlPapasamyam']['papaPlanet'][$fromPlanet]['planetDosha'][$papaPlanet]['position']?></td>
                            <td><?=$papaSamyamCheckResult['girlPapasamyam']['papaPlanet'][$fromPlanet]['planetDosha'][$papaPlanet]['hasDosha'] ? 1 : 0?></td>
                        <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>

                <tr><th colspan="7" class="text-center">Total Papa Points : <?=$papaSamyamCheckResult['girlPapasamyam']['total_point']?></th> </tr>
            </table>
            <h3 class="text-black">Boy Papa Points</h3>
            <table class="table table-bordered table-responsive-sm table-hover">
                <thead class="bg-secondary text-white">
                    <tr><th rowspan="2">Boy Papa Points</th><th colspan="2">From Ascendant</th>
                        <th colspan="2">From Moon</th><th colspan="2">From Venus</th>
                    </tr>
                    <tr><th>Position</th><th>Papam</th><th>Position</th>
                        <th>Papam</th><th>Position</th><th>Papam</th>
                    </tr>
                </thead>
                <?php foreach ($arPapaPlanets as $papaPlanet => $papaPlanetName):?>
                    <tr><th><?=$papaPlanetName?></th>
                    <?php foreach ($arPapaFromPlanets as $fromPlanet => $fromPlanetName):?>
                        <td><?=$papaSamyamCheckResult['boyPapasamyam']['papaPlanet'][$fromPlanet]['planetDosha'][$papaPlanet]['position']?></td>
                        <td><?=$papaSamyamCheckResult['boyPapasamyam']['papaPlanet'][$fromPlanet]['planetDosha'][$papaPlanet]['hasDosha'] ? 1 : 0?></td>
                    <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                <tr><th colspan="7" class="text-center">Total Papa Points : <?=$papaSamyamCheckResult['boyPapasamyam']['total_point']?></th> </tr>
            </table>
            <div class="alert  p-4 text-center
            <?='Excellent' === $papaSamyamCheckResult['message']['type'] ? 'alert-success' :
                ('Satisfactory' === $papaSamyamCheckResult['message']['type'] ? 'alert-warning' : 'alert-danger')?>" role="alert">
                Papasamyam for this couple is <b><?=$papaSamyamCheckResult['message']['type']?></b><br>
                <?=$papaSamyamCheckResult['message']['description']?>
            </div>
        <?php endif; ?>
        <section>

            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="" method="POST">
                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-xs-left">Ayanamsa</label>
                        <div class="col-sm-9 col-md-6">
                            <select name="ayanamsa" class="form-control form-control-lg rounded-1">
                                <option value="1" <?=1 == $ayanamsa ? 'selected' : ''?>>Lahiri</option>
                                <option value="3" <?=3 == $ayanamsa ? 'selected' : ''?>>Raman</option>
                                <option value="5" <?=5 == $ayanamsa ? 'selected' : ''?>>KP</option>
                            </select>
                        </div>
                    </div>
                    <?php include 'common/porutham-form.tpl.php'; ?>
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
