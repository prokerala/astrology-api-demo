<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calendar Astrology API Demo</title>
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
                        <span class="font-weight-thin">Calendar</span>
                    </h2>
<!--                    <p class="text-white">Auspicious period shows results like Abhijit Muhurat, Amrit Kaal and Brahma Muhurat. <a class="text-warning" href="https://www.prokerala.com/astrology/panchangam/" target="_blank">Read More..</a></p>-->
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">

        <?php include 'common/helper.tpl.php'; ?>
        <?php if(!empty($result)): ?>
            <h2 class="text-center text-black">Calendar</h2>
            <table class="table table-bordered text-large text-center table-hover">
                <tr><td>Gregorian Date</td><td><?=$date->format('d M, Y')?></td></tr>
                <tr><td>Calendar Name </td><td><?=$result->getCalendarDate()->getName()?></td></tr>
                <tr><td>Year</td><td><?=$result->getCalendarDate()->getYear()?></td></tr>
                <tr><td>Month</td><td><?=$result->getCalendarDate()->getMonth()?></td></tr>
                <tr><td>Day</td><td><?=$result->getCalendarDate()->getDay()?></td></tr>
                <?php if(!in_array(strtolower(trim($result->getCalendarDate()->getName())), ['hijri', 'gujarati', 'bengali', 'malayalam', 'tamil'], true)): ?>
                    <tr><td>Leap</td><td><?=$result->getCalendarDate()->getLeap()?></td></tr>
                <?php endif; ?>
                <?php if(!in_array(strtolower(trim($result->getCalendarDate()->getName())), ['hijri', 'gujarati', 'bengali', 'malayalam'], true)): ?>
                    <tr><td>Year Name</td><td><?=$result->getCalendarDate()->getYearName()?></td></tr>
                <?php endif; ?>
                <tr><td>Month Name</td><td><?=$result->getCalendarDate()->getMonthName()?></td></tr>
            </table>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="calendar.php" method="POST">
                        <?php include 'common/calendar-form.tpl.php'; ?>
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

    var calendarSupportedLanguages = <?=json_encode($arSupportedLanguages)?>;

    document.getElementById('fin-select-calendar').addEventListener('change', function () {
        var calendar = this.value;
        selectedLanguages = calendarSupportedLanguages[calendar];
        var html = '';
        for (const [key, value] of Object.entries(selectedLanguages)) {
            html += `<option value="${key}">${value}</option>`;
        }

        document.getElementById('fin-supported-languages').innerHTML = html;
    });

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
