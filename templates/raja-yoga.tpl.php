<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vedic Astrology Raja Yoga | Astrology API Demo - Prokerala Astrology</title>
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


    <p class="mt-1"></p>
    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>
            <h3>Sorting based on influence</h3>
            <div class="table-responsive mb-6">

            <?php foreach ($yogaListInfluence as $key => $yogaListInfluenceLists): ?>
             Under <strong> <?=$influenceKey[$key]?></strong> there are <strong> <?= count($yogaListInfluenceLists)  ?></strong> yoga's found

            <p class="font-weight-bold mb-0 mt-4"></p>
            <table class="table table-bordered table-hover">
                <tr class="bg-secondary text-white text-center">
                    <td class="text-center">No.</td>
                    <td class="text-center">Name</td>
                    <td class="text-center">Influence</td>
                    <td class="text-center">Combination</td>
                    <td class="text-center">Nature</td>
                    <td class="text-center">Category</td>
                </tr>

                <?php foreach ($yogaListInfluenceLists as $key1 => $yoga): ?>
                    <tr>
                        <td> <?= $key1 + 1 ?> </td>
                        <td> <?= $yoga->getName() ?> </td>
                        <td>
                            <?php foreach ($yoga->getInfluence() as $val): ?>
                                <?= $val->getName() ?>
                            <?php endforeach;?>
                        </td>

                        <td>
                            <?php foreach ($yoga->getCombination() as $val): ?>
                                <?= $val->getName() ?>
                            <?php endforeach;?>
                        </td>

                        <td>
                            <?= $yoga->getNature()->getName() ?>
                        </td>

                        <td>
                            <?php foreach ($yoga->getCategory() as $val): ?>
                                <?= $val->getName() ?>
                            <?php endforeach;?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php endforeach; ?>
            </div>


            <h3 class="mt-6">Sorting based on Category</h3>
            <div class="table-responsive mb-6">

            <?php foreach ($yogaListCategory as $key => $value): ?>
                Based on yoga's there are <strong> <?=count($value)?> </strong> <strong> <?=$categoryKey[$key]?> </strong> yoga's found


                <p class="font-weight-bold mb-0 mt-4"></p>
                <table class="table table-bordered table-hover">
                    <tr class="bg-secondary text-white text-center">
                        <td class="text-center">No.</td>
                        <td class="text-center">Name</td>
                        <td class="text-center">Influence</td>
                        <td class="text-center">Combination</td>
                        <td class="text-center">Nature</td>
                        <td class="text-center">Category</td>
                    </tr>

                    <?php foreach ($value as $key1 => $yoga): ?>
                        <tr>
                            <td> <?= $key1 + 1 ?> </td>
                            <td> <?= $yoga->getName() ?> </td>
                            <td>
                                <?php foreach ($yoga->getInfluence() as $val): ?>
                                    <?= $val->getName() ?>
                                <?php endforeach;?>
                            </td>

                            <td>
                                <?php foreach ($yoga->getCombination() as $val): ?>
                                    <?= $val->getName() ?>
                                <?php endforeach;?>
                            </td>

                            <td>
                                <?= $yoga->getNature()->getName() ?>
                            </td>

                            <td>
                                <?php foreach ($yoga->getCategory() as $val): ?>
                                    <?= $val->getName() ?>
                                <?php endforeach;?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
            </div>



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

