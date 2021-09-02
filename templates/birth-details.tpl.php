<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vedic Astrology Birth Details | Astrology API Demo - Prokerala Astrology</title>
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
                        <span class="font-weight-thin">Birth Details</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>
            <table class="table table-bordered table-hover">
                <tr class="bg-secondary text-white text-center"><td colspan="2" class="text-center">Nakshatra Details</td></tr>
                <tr><td>Nakshatra</td><td><?=$nakshatra_details['nakshatra']->getName()?></td></tr>
                <tr><td>Nakshatra Pada</td><td><?=$nakshatra_details['nakshatra']->getPada()?></td></tr>
                <tr><td>Nakshatra Lord</td><td><?=$nakshatra_details['nakshatra']->getLord()?></td></tr>
                <tr><td>Chandra Rasi</td><td><?=$nakshatra_details['chandra_rasi']->getName()?></td></tr>
                <tr><td>Chandra Rasi Lord</td><td><?=$nakshatra_details['chandra_rasi']->getLord() . '(' . $nakshatra_details['chandra_rasi']->getLord()->getVedicName() . ')'?></td></tr>
                <tr><td>Soorya Rasi</td><td><?=$nakshatra_details['soorya_rasi']->getName()?></td></tr>
                <tr><td>Soorya Rasi Lord</td><td><?=$nakshatra_details['soorya_rasi']->getLord() . '(' . $nakshatra_details['soorya_rasi']->getLord()->getVedicName() . ')'?></td></tr>
                <tr><td>Zodiac</td><td><?=$nakshatra_details['zodiac']->getName()?></td></tr>
                <tr class="bg-secondary text-white text-center"><td colspan="2" class="text-center">Additional Info</td></tr>
                <?php foreach ($nakshatra_additional_info as $key => $data):?>
                    <tr><td><?= $key?></td><td><?=$data?></td></tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="" method="POST">
                        <?php include 'common/horoscope-form.tpl.php'; ?>
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
