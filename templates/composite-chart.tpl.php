<?php include __DIR__ . '/translations/western/trans.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Composite Chart | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css?_=20231214">

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
                        <span class="font-weight-thin"><?= __('Composite Chart') ?></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <h3 class="text-center"><?= __('Composite Chart') ?></h3>
            <div id="chart" class="d-flex justify-content-center">
                <?= str_replace('<svg ', '<svg preserveAspectRatio="none" viewBox="0 0 600 600" ', $chart); ?>
            </div>

            <h3 class="text-center"><?= __('Composite Aspect Chart') ?></h3>
            <div id="chart" class="d-flex justify-content-center">
                <?= str_replace('<svg ', '<svg preserveAspectRatio="none" viewBox="0 0 710 470" ', $aspectChart); ?>
            </div>


            <!--            House table-->
            <h3 class="text-center m-5"><?= __('Composite House Cusps') ?></h3>
            <table class="table table-bordered">
                <tr>
                    <th><?= __('House') ?></th>
                    <th><?= __('Start Cusp') ?></th>
                    <th><?= __('End Cusp') ?></th>
                </tr>
                <?php foreach($houses as $house): ?>
                    <tr>
                        <td><?=$house->getNumber()?></td>
                        <td><?=round($house->getStartCusp()->getLongitude(), 2)?></td>
                        <td><?=round($house->getEndCusp()->getLongitude(), 2)?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h3 class="text-center"><?= __('Composite Planet Position') ?></h3>
            <table class="table table-bordered m-5">
                <tr>
                    <th><?= __('Planet') ?></th>
                    <th><?= __('Longitude') ?></th>
                    <th><?= __('Degree') ?></th>
                    <th><?= __('House') ?></th>
                    <th><?= __('Zodiac') ?></th>
                </tr>
                <?php foreach($planetPositions as $planetPosition): ?>
                    <tr>
                        <td><?=$planetPosition->getName()?></td>
                        <td><?=round($planetPosition->getLongitude(), 2)?></td>
                        <td><?=round($planetPosition->getDegree(), 2)?></td>
                        <td><?=$planetPosition->getHouseNumber()?></td>
                        <td><?=$planetPosition->getZodiac()->getName()?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h3 class="text-center">Composite Angles</h3>
            <table class="table table-bordered m-5">
                <tr>
                    <th><?= __('Angles') ?></th>
                    <th><?= __('Longitude') ?></th>
                    <th><?= __('Degree') ?></th>
                    <th><?= __('House') ?></th>
                    <th><?= __('Zodiac') ?></th>
                </tr>
                <?php foreach($angles as $planetPosition): ?>
                    <tr>
                        <td><?=$planetPosition->getName()?></td>
                        <td><?=round($planetPosition->getLongitude(), 2)?></td>
                        <td><?=round($planetPosition->getDegree(), 2)?></td>
                        <td><?=$planetPosition->getHouseNumber()?></td>
                        <td><?=$planetPosition->getZodiac()->getName()?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h3 class="text-center m-5"><?= __('Composite Planet Aspect') ?></h3>
            <table class="table table-bordered">
                <tr>
                    <th><?= __('Planet 1') ?></th>
                    <th><?= __('Aspect') ?></th>
                    <th><?= __('Planet 2') ?></th>
                    <th><?= __('Orb') ?></th>
                </tr>

                <tr><th class="text-center" colspan="4"><?= __('Major Aspects') ?></th></tr>

                <?php foreach($aspects as $aspect): ?>
                    <?php if(!in_array($aspect->getAspect()->getName(), ['Opposition', 'Conjunction', 'Sextile', 'Square', 'Trine'])): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <tr>
                        <td><?=$aspect->getPlanetOne()->getName()?></td>
                        <td><?=$aspect->getAspect()->getName()?></td>
                        <td><?=$aspect->getPlanetTwo()->getName()?></td>
                        <td><?=round($aspect->getOrb(), 2)?></td>
                    </tr>
                <?php endforeach; ?>

                <tr><th class="text-center" colspan="4"><?= __('Minor Aspects') ?></th></tr>

                <?php foreach($aspects as $aspect): ?>
                    <?php if(in_array($aspect->getAspect()->getName(), ['Opposition', 'Conjunction', 'Sextile', 'Square', 'Trine'])): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <tr>
                        <td><?=$aspect->getPlanetOne()->getName()?></td>
                        <td><?=$aspect->getAspect()->getName()?></td>
                        <td><?=$aspect->getPlanetTwo()->getName()?></td>
                        <td><?=round($aspect->getOrb(), 2)?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <section>
            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="composite-chart.php" method="POST">
                    <?php include 'common/synastry-form.tpl.php'; ?>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label text-md-right text-xs-left">Language: </label>
                        <div class="col-sm-9 col-md-6">
                            <select name="la" class="form-control form-control-lg rounded-1">
                                <option value="en" selected>English</option>
                                <option value="de">German</option>
                            </select>
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
<script>
(function () {
    function loadScript(cb) {
        var script = document.createElement('script');
        script.src = 'https://client-api.prokerala.com/static/js/location.min.js';
        script.onload = cb;
        script.async = 1;
        document.head.appendChild(script);
    }

    function createInput(name, value) {
        const input = document.createElement('input');
        input.name = name;
        input.type = 'hidden';

        return input;
    }
    function initWidget(input) {
        const form = input.form;
        const inputPrefix = input.dataset.location_input_prefix ? input.dataset.location_input_prefix : '';
        const coordinates = createInput(inputPrefix +'coordinates');
        const timezone = createInput(inputPrefix +'timezone');
        form.appendChild(coordinates);
        form.appendChild(timezone);
        new LocationSearch(input, function (data) {
            coordinates.value = `${data.latitude},${data.longitude}`;
            timezone.value = data.timezone;
            input.setCustomValidity('');
        }, {clientId: CLIENT_ID, persistKey: `${inputPrefix}loc`});

        input.addEventListener('change', function (e) {
            input.setCustomValidity('Please select a location from the suggestions list');
        });
    }
    loadScript(function() {
        let location = document.querySelectorAll('.prokerala-location-input');
        Array.from(location).map(initWidget);
    });
})();
</script>
<!-- CODE FOR LOCATION SEARCH ENDS -->
</body>
</html>
