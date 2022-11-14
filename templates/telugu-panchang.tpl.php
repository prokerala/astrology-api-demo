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
                        <span class="font-weight-thin">Telugu Panchang</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <h2 class="text-center text-black">Telugu Panchang Details</h2>
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
                                <?=$value['start']->format('d M, Y, h:i A') . ' - ' . $value['end']->format('d M, Y, h:i A')?></span>
                        <?php endforeach; ?>

                    <?php elseif ('vaara' === $key):?>
                        <span class="text-black d-block"><b><?= ucwords($key)?></b> : <?=$data?></span>
                    <?php else:?>
                        <span class="text-black d-block"><b><?= ucwords($key)?></b> : <?=$data->format('h:i A')?></span>
                    <?php endif; ?>
                <?php endforeach?>
                <hr>
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
                        <td>Start: <?=$rituResult->getVedicRitu()->getStart()->format('d M, Y, h:i A')?></td>
                        <td>Start: <?=$rituResult->getDrikRitu()->getStart()->format('d M, Y, h:i A')?></td>
                    </tr>
                    <tr class="border-top">
                        <td>End: <?=$rituResult->getVedicRitu()->getEnd()->format('d M, Y, h:i A')?></td>
                        <td>End: <?=$rituResult->getDrikRitu()->getEnd()->format('d M, Y, h:i A')?></td>
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
                <span class="text-black d-block b"><?= ucwords('Chandra Bala')?></span>
                <?php foreach ($chandraBalaResult->getChandraBala() as $chandraBala): ?>
                    <table class="table table-bordered text-large text-center table-hover">
                        <tr><td class="text-right">Rasi</td>
                            <td class="text-left">
                                <?php foreach ($chandraBala->getRasis() as $rasi): ?>
                                    <?=$rasi->getName()?>,
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr><td class="text-right">Start</td><td class="text-left"><?=$chandraBala->getStart()->format('d M, Y, h:i A')?></td></tr>
                        <tr><td class="text-right">End</td><td class="text-left"><?=$chandraBala->getEnd()->format('d M, Y, h:i A')?></td></tr>
                    </table>
                <?php endforeach; ?>
                <span class="text-black d-block b"><?= ucwords('Tara Bala')?></span>
                <?php foreach($taraBalaResult->getTaraBala() as $taraBala): ?>
                    <table class="table table-bordered text-large text-center table-hover">
                        <tr><td class="text-right">Nakshatra</td>
                            <td class="text-left">
                                <?php foreach ($taraBala->getNakshatras() as $nakshatra): ?>
                                    <?=$nakshatra->getName()?>,
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr><td class="text-right">Start</td><td class="text-left"><?=$taraBala->getStart()->format('d M, Y, h:i A')?></td></tr>
                        <tr><td class="text-right">End</td><td class="text-left"><?=$taraBala->getEnd()->format('d M, Y, h:i A')?></td></tr>
                    </table>
                <?php endforeach; ?>
                <span class="text-black d-block b"><?= ucwords('Calendar')?></span>
                <table class="table table-bordered text-large text-center table-hover">
                    <tr><td>Gregorian Date</td><td><?=$datetime->format('d M, Y')?></td></tr>
                    <tr><td>Calendar Name </td><td><?=$calendarResult->getCalendarDate()->getName()?></td></tr>
                    <tr><td>Year</td><td><?=$calendarResult->getCalendarDate()->getYear()?></td></tr>
                    <tr><td>Month</td><td><?=$calendarResult->getCalendarDate()->getMonth()?></td></tr>
                    <tr><td>Day</td><td><?=$calendarResult->getCalendarDate()->getDay()?></td></tr>
                    <?php if(!in_array(strtolower(trim($calendarResult->getCalendarDate()->getName())), ['hijri', 'gujarati', 'bengali', 'kolla-varsham', 'tamil'], true)): ?>
                        <tr><td>Leap</td><td><?=$calendarResult->getCalendarDate()->getLeap()?></td></tr>
                    <?php endif; ?>
                    <?php if(!in_array(strtolower(trim($calendarResult->getCalendarDate()->getName())), ['hijri', 'gujarati', 'bengali', 'kolla-varsham'], true)): ?>
                        <tr><td>Year Name</td><td><?=$calendarResult->getCalendarDate()->getYearName()?></td></tr>
                    <?php endif; ?>
                    <tr><td>Month Name</td><td><?=$calendarResult->getCalendarDate()->getMonthName()?></td></tr>
                </table>
            </div>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="telugu-panchang.php" method="POST">
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
