<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panchang | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">
    <style>
        .panchang-details{
            max-width:800px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 2rem;
        }
    </style>

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
                        <span class="font-weight-thin">Hindu Panchang</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <h2 class="text-center text-black">Hindu Panchang Details</h2>
            <div class="panchang-details">
                <?php foreach ($panchangResult as $key => $data): ?>

                    <?php if (in_array($key, ['Nakshatra', 'Tithi', 'Karana', 'Yoga'], true)):?>
                        <hr>
                        <span class="text-black d-block b"><?= ucwords($key)?></span>
                        <?php foreach ($data as $idx => $value):?>
                            <span class="text-black d-block"><?=$value['name']?>

                            <?php if ('Nakshatra' === $key):?>
                                (Lord: <?= $value['nakshatra_lord']?>) :
                            <?php endif; ?>
                                <?=$value['start']->format('h:i A') . ' - ' . $value['end']->format('h:i A')?></span>
                        <?php endforeach; ?>

                    <?php elseif ('vaara' === $key):?>
                        <span class="text-black d-block"><b><?= ucwords($key)?></b> : <?=$data?></span>
                    <?php else:?>
                        <span class="text-black d-block"><b><?= ucwords($key)?></b> : <?=$data->format('h:i A')?></span>
                    <?php endif; ?>
                <?php endforeach?>

                    <table class="table table-bordered">
                        <tr class="alert-success text-center"><td colspan="2">Auspicious Timing</td></tr>
                        <?php foreach ($auspiciousPeriod as $muhuratName => $muhuratDetails):?>
                            <tr>
                                <td><?= ucwords($muhuratName)?></td><td>
                                    <?php foreach ($muhuratDetails as $idx => $value):?>
                                        <?=$value['start']->format('h:i A')?> - <?=$value['end']->format('h:i A')?><br>

                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="alert-danger text-center"><td colspan="2">Inauspicious Timing</td></tr>
                        <?php foreach ($inAuspiciousPeriod as $muhuratName => $muhuratDetails):?>
                            <tr>
                                <td><?= ucwords($muhuratName)?></td><td>
                                    <?php foreach ($muhuratDetails as $idx => $value):?>
                                        <?=$value['start']->format('h:i A')?> - <?=$value['end']->format('h:i A')?><br>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <span class="text-black d-block b"><?= ucwords('Hora Timing')?></span>
                    <div class="grid-col grid-col-xs-12 grid-col-sm-6">
                        <div>
                            <table class="table table-bordered table-sm table-hora-result t-small">
                                <thead class="bg-secondary text-white">
                                <tr><th colspan="3" class="tc t-xlarge">Day Hora</th></tr>
                                <tr><th>Hora</th><th>Type</th><th> Time</th></tr>
                                </thead>
                                <tbody>
                                <?php foreach ($horaResult->getDayHora() as $key => $data):?>
                                    <tr class="border-top">
                                        <td><?=$data->getHora()->getName()?></td>
                                        <td><?=$data->getType()?></td>
                                        <td><?=$data->getStart()->format('h:i A') . ' - ' . $data->getEnd()->format('h:i A')?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <table class="table table-bordered table-sm table-hora-result t-small">
                                <thead class="bg-secondary text-white">
                                <tr><th colspan="3" class="tc t-xlarge">Night Hora</th></tr>
                                <tr><th>Hora</th><th>Type</th><th> Time</th></tr>
                                </thead>
                                <tbody>
                                <?php foreach ($horaResult->getNightHora() as $key => $data):?>
                                    <tr class="border-top">
                                        <td><?=$data->getHora()->getName()?></td>
                                        <td><?=$data->getType()?></td>
                                        <td><?=$data->getStart()->format('h:i A') . ' - ' . $data->getEnd()->format('h:i A')?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <span class="text-black d-block b"><?= ucwords('Ritu')?></span>
                        <table class="table table-bordered text-large text-center table-hover">
                            <thead>
                            <tr>
                                <th>Vedic Ritu</th>
                                <th>Drik Ritu</th>
                            </tr>
                            </thead>
                            <tr class="border-top">
                                <td><?=$rituResult->getVedicRitu()->getName()?></td>
                                <td><?=$rituResult->getDrikRitu()->getName()?></td>
                            </tr>
                            <tr class="border-top">
                                <td><?=$rituResult->getVedicRitu()->getVedicName()?></td>
                                <td><?=$rituResult->getDrikRitu()->getVedicName()?></td>
                            </tr>
                            <tr class="border-top">
                                <td>Start: <?=$rituResult->getVedicRitu()->getStart()?></td>
                                <td>Start: <?=$rituResult->getDrikRitu()->getStart()?></td>
                            </tr>
                            <tr class="border-top">
                                <td>End: <?=$rituResult->getVedicRitu()->getEnd()?></td>
                                <td>End: <?=$rituResult->getDrikRitu()->getEnd()?></td>
                            </tr>
                        </table>
                        <span class="text-black d-block b"><?= ucwords('Solstice')?></span>
                        <table class="table table-bordered text-large text-center table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Vedic Name</th>
                            </tr>
                            </thead>
                            <tr class="border-top">
                                <td><?=$solsticeResult->getDishaShool()->getName()?></td>
                                <td><?=$solsticeResult->getDishaShool()->getVedicName()?></td>
                            </tr>
                        </table>
                        <span class="text-black d-block b"><?= ucwords('Anandadi Yoga')?></span>
                        <div class="grid-col grid-col-xs-12 grid-col-sm-6">
                            <div>
                                <table class="table table-bordered table-sm table-hora-result t-small">
                                    <tr>
                                        <?php foreach($anandadiYogaResult->getAnandadiYoga() as $data): ?>
                                            <table  class="table table-bordered table-sm table-hora-result t-small">
                                                <tr class="font-weight-bold"><td>Name</td><td><?=$data->getName()?> Yoga</td></tr>
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
                        <span class="text-black d-block b"><?= ucwords('Disha Shool')?></span>
                        <div class="grid-col grid-col-xs-12 grid-col-sm-6">
                            <div>
                                <table class="table table-bordered table-sm table-hora-result t-small">
                                    <tbody>
                                    <tr><td>Direction</td><td><?=$dishaShoolResult->getDishaShool()->getDirection()?></td></tr>
                                    <tr><td>Remedy</td><td><?=$dishaShoolResult->getDishaShool()->getRemedy()?></td></tr>
                                    <tr><td>Start</td><td><?=$dishaShoolResult->getDishaShool()->getStart()->format('c')?></td></tr>
                                    <tr><td>End</td><td><?=$dishaShoolResult->getDishaShool()->getEnd()->format('c')?></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="hindu-panchang.php" method="POST">
                        <?php include 'common/panchang-form.tpl.php'; ?>
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
