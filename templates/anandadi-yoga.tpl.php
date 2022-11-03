<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hora Astrology API Demo</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">
    <style>
        .table{
            max-width: 800px;
            margin: auto;
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
                        <span class="font-weight-thin">Anandadi Yoga</span>
                    </h2>
<!--                    <p class="text-white">Auspicious period shows results like Abhijit Muhurat, Amrit Kaal and Brahma Muhurat. <a class="text-warning" href="https://www.prokerala.com/astrology/panchangam/" target="_blank">Read More..</a></p>-->
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>
        <?php if(!empty($result)): ?>
            <h2 class="text-center text-black">Anandadi Yoga</h2>
            <div class="grid-col grid-col-xs-12 grid-col-sm-6">
                <div>
                    <table class="table table-bordered table-sm table-hora-result t-small">
                        <tr>
                            <?php foreach($result->getAnandadiYoga() as $data): ?>
                            <table  class="table table-bordered table-sm table-hora-result t-small">
                                <tr class="font-weight-bold"><td>Name</td><td><?=$data->getName()?></td></tr>
                                <tr><td>Type</td><td><?=$data->getType()?></td></tr>
                                <tr><td>Status</td><td><?=$data->getDescription()?></td></tr>
                                <tr><td>Start</td><td><?=$data->getStart()->format('c')?></td></tr>
                                <tr><td>End</td><td><?=$data->getEnd()->format('c')?></td></tr>
                            </table>
                            <?php endforeach; ?>
                        </tr>

                    </table>
                </div>
            </div>
        <?php endif; ?>
        <section>
            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="anandadi-yoga.php" method="POST">
                    <?php include 'common/panchang-form.tpl.php'; ?>
                    <div class="text-right">
                        <button type="submit" class="btn btn-warning btn-submit ">Get Result</button>
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
