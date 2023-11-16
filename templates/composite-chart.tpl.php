<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Composite Chart | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">

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
                        <span class="font-weight-thin">Composite Chart</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <h3 class="text-center">Composite Chart</h3>
            <div id="chart" class="d-flex justify-content-center">
                <?= str_replace('<svg ', '<svg preserveAspectRatio="none" viewBox="0 0 600 600" ', $chart); ?>
            </div>

            <h3 class="text-center">Composite Aspect Chart</h3>
            <div id="chart" class="d-flex justify-content-center">
                <?= str_replace('<svg ', '<svg preserveAspectRatio="none" viewBox="0 0 710 470" ', $aspectChart); ?>
            </div>


            <!--            House table-->
            <h3 class="text-center m-5">Composite Houses</h3>
            <table class="table table-bordered">
                <tr>
                    <th>House</th>
                    <th>Start Degree</th>
                    <th>End Degree</th>
                </tr>
                <?php foreach($houses as $house): ?>
                    <tr>
                        <td><?=$house->getNumber()?></td>
                        <td><?=$house->getStartDegree()?></td>
                        <td><?=$house->getEndDegree()?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h3 class="text-center">Composite Planet Position</h3>
            <table class="table table-bordered m-5">
                <tr>
                    <th>Planet</th>
                    <th>Longitude</th>
                    <th>Motion</th>
                    <th>Degree</th>
                    <th>House</th>
                    <th>Zodiac</th>
                </tr>
                <?php foreach($planetPositions as $planetPosition): ?>
                    <tr>
                        <td><?=$planetPosition->getName()?></td>
                        <td><?=round($planetPosition->getLongitude(), 3)?></td>
                        <td><?=$planetPosition->isRetrograde() === true ? 'Retrograde' : 'Forward'?></td>
                        <td><?=round($planetPosition->getDegree(), 3)?></td>
                        <td><?=$planetPosition->getHouseNumber()?></td>
                        <td><?=$planetPosition->getZodiac()->getName()?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h3 class="text-center">Composite Angles</h3>
            <table class="table table-bordered m-5">
                <tr>
                    <th>Planet</th>
                    <th>Longitude</th>
                    <th>Motion</th>
                    <th>Degree</th>
                    <th>House</th>
                    <th>Zodiac</th>
                </tr>
                <?php foreach($angles as $planetPosition): ?>
                    <tr>
                        <td><?=$planetPosition->getName()?></td>
                        <td><?=round($planetPosition->getLongitude(), 3)?></td>
                        <td><?=$planetPosition->isRetrograde() === true ? 'Retrograde' : 'Forward'?></td>
                        <td><?=round($planetPosition->getDegree(), 3)?></td>
                        <td><?=$planetPosition->getHouseNumber()?></td>
                        <td><?=$planetPosition->getZodiac()->getName()?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h3 class="text-center m-5">Composite Planet Aspect</h3>
            <table class="table table-bordered">
                <tr>
                    <th>Planet 1</th>
                    <th>Planet 2</th>
                    <th>Aspect</th>
                    <th>Orb</th>
                </tr>
                <?php foreach($aspects as $aspect): ?>
                    <tr>
                        <td><?=$aspect->getPlanetOne()->getName()?></td>
                        <td><?=$aspect->getPlanetTwo()->getName()?></td>
                        <td><?=$aspect->getAspect()->getName()?></td>
                        <td><?=$aspect->getOrb()?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <section>
            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="composite-chart.php" method="POST">
                    <?php include 'common/synastry-form.tpl.php'; ?>
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
