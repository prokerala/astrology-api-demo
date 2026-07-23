<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>KP Charts | Astrology API Demo - Prokerala Astrology</title>
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
                        <span class="font-weight-thin">KP Astrology</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">

        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>
            <div class="row">
                <div class="text-center m-auto col-12 overflow-auto">
                    <h3>KP Chart</h3>
                    <?php echo $result; ?>
                </div>
            </div>
        <?php endif; ?>


            <div class="container prokerala-api-demo-container">

                <?php if (!empty($result)): ?>
                    <h3 class="text-center">Planet Positions</h3>
                    <table class="table table-bordered table-hover table-responsive-sm">
                        <tr class="bg-secondary text-white">
                            <th>Planets</th>
                            <th>Nakshatra</th>
                            <th>House</th>
                            <th>Degree</th>
                            <th>Rasi</th>
                            <th>Nakshatra Lord</th>
                            <th>Sub Lord</th>
                            <th>Sub Sub Lord</th>
                        </tr>
                        <?php foreach ($planetPositionResult as $planet): ?>
                            <tr>
                                <td><?=$planet['name']?></td>
                                <td><?=$planet['nakshatra']?></td>
                                <td><?=$planet['house']?></td>
                                <td><?=$planet['degree']?></td>
                                <td><?=$planet['rasi']?></td>
                                <td><?=$planet['nakshatraLord']?></td>
                                <td><?=$planet['subLord']?></td>
                                <td><?=$planet['subSubLord']?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>

                <?php if (!empty($result)): ?>
                    <h3 class="text-center">Houses</h3>
                    <table class="table table-bordered table-hover table-responsive-sm">
                        <tr class="bg-secondary text-white">
                            <th>House</th>
                            <th>Rasi</th>
                            <th>Degree</th>
                            <th>Nakshatra</th>
                            <th>Nakshatra Lord</th>
                            <th>Sub Lord</th>
                            <th>Sub Sub Lord</th>
                        </tr>
                        <?php foreach ($housesResult as $house): ?>
                            <tr>
                                <td><?=$house['house']?></td>
                                <td><?=$house['rasi']?></td>
                                <td><?=$house['degree']?></td>
                                <td><?=$house['nakshatra']?></td>
                                <td><?=$house['nakshatra_lord']?></td>
                                <td><?=$house['sub_lord']?></td>
                                <td><?=$house['sub_sub_lord']?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
                <div class="container prokerala-api-demo-container">

                    <?php if (!empty($result)): ?>
                        <h3 class="text-center">Kp Planet Significator</h3>
                        <table class="table table-bordered table-hover table-responsive-sm">
                            <tr class="bg-secondary text-white">
                                <th>planet</th>
                                <th>Nakshatra Lord House</th>
                                <th>Occupied House</th>
                                <th>Rasi Lord House</th>
                                <th>Rasi Lord Own House</th>
                            </tr>
                            <?php foreach ($planetsignificatorResult as $planet): ?>
                                <tr>
                                    <td><?= $planet['planet'] ?></td>
                                    <td><?= $planet['nakshatra_lord_house'] ?></td>
                                    <td><?= $planet['occupied_house'] ?></td>

                                    <td>
                                        <?php if (empty($planet['rasi_lord_house'])): ?>
                                            -
                                        <?php else: ?>
                                            <?= implode(', ', array_map(fn ($p) => $p->getName(), $planet['rasi_lord_house'])) ?>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (empty($planet['rasi_lord_own_house'])): ?>
                                            -
                                        <?php else: ?>
                                            <?= implode(', ', array_map(fn ($p) => $p->getName(), $planet['rasi_lord_own_house'])) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>

                    <div class="container prokerala-api-demo-container">

                        <?php if (!empty($result)): ?>
                            <h3 class="text-center">Kp House Significator</h3>
                            <table class="table table-bordered table-hover table-responsive-sm">
                                <tr class="bg-secondary text-white">
                                    <th>House</th>
                                    <th>Cusp Nakshatra Occupants</th>
                                    <th>Cusp Occupants</th>
                                    <th>Cusp Owner Nakshatra Planets</th>
                                    <th>Cusp Owner</th>
                                </tr>
                                <?php foreach ($houseSignificatorResult as $planet): ?>
                                    <tr>
                                        <td><?= $planet['house'] ?></td>

                                        <td>
                                            <?php if (empty($planet['nakshatraOccupants'])): ?>
                                                -
                                            <?php else: ?>
                                                <?= implode(', ', array_map(fn ($p) => $p->getName(), $planet['nakshatraOccupants'])) ?>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if (empty($planet['occupants'])): ?>
                                                -
                                            <?php else: ?>
                                                <?= implode(', ', array_map(fn ($p) => $p->getName(), $planet['occupants'])) ?>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if (empty($planet['nakshatraPlanets'])): ?>
                                                -
                                            <?php else: ?>
                                                <?= implode(', ', array_map(fn ($p) => $p->getName(), $planet['nakshatraPlanets'])) ?>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= $planet['cuspOwner'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>
                    </div>

                <section>
            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="kp-astrology.php" method="POST">
                    <?php include 'common/horoscope-form.tpl.php'; ?>
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
