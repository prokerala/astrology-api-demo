<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dasha Periods | Vimsottari Dasha | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">
    <style>
        .table-dashas{
            max-width:100%;
        }
        @media (min-width: 576px) {
            .table-dashas{
                margin:.5%;
                max-width:49%;
            }
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
                        <span class="font-weight-thin">Dasha Periods | Vimsottari Dasha</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>
        <h2>Maha Dasha</h2>
            <table class="table table-bordered mb-5 col-12 col-md-6 text-small table-dashas">
                <thead>
                <tr>
                    <th>Mahadasha</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($kundliResult['dashaPeriods'] as $maha_dasha): ?>

                    <?php $maha_dasha_lord = $maha_dasha['name'] ?>
                    <tr>
                        <td class="b"><?=$maha_dasha_lord?></td>
                        <td><?=$maha_dasha['start']->format('d-M, Y')?></td>
                        <td><?=$maha_dasha['end']->format('d-M, Y')?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php foreach ($kundliResult['dashaPeriods'] as $mahadashas):?>
                <h3 class="text-black">Anthardashas in <?=$mahadashas['name']?> Mahadasha</h3>
                <div class="row">
                <?php foreach ($mahadashas['antardasha'] as $anthardashas):?>
                    <table class="table table-bordered mb-5 col-12 col-md-6 text-small table-dashas">
                        <tr><th>AD</th><th>PD</th><th>Starts</th><th>Ends</th></tr>
                    <?php foreach ($anthardashas['pratyantardasha'] as $paryantradashas):?>
                    <tr>
                        <td><?=$anthardashas['name']?></td>
                        <td><?=$paryantradashas['name']?></td>
                        <td><?=$paryantradashas['start']->format('d-m-Y')?></td>
                        <td><?=$paryantradashas['end']->format('d-m-Y')?></td>
                    </tr>
                    <?php endforeach; ?>
                    </table>
                <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <p class="text-small text-right text-danger"><span class="text-danger">**</span> AD stands for Antardasha &  PD stands for Paryantra dasha</p>
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
