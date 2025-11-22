<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Batch Compatibility | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?= DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?= DEMO_BASE_URL?>/build/reports.css">
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
                        <span class="font-weight-thin">Batch Compatibility</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">

        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>

        <div class="d-flex flex-column align-items-center justify-content-center">
            <h2 class="text-center text-black">Profile</h2>
            <table class="table table-bordered text-large text-center table-hover w-50">
                <thead>
                <tr>
                    <th>Name</th>
                    <th><?=$inputProfile['name'] ?? 'Not Given'?></th>
                </tr>
                </thead>
                <tr class="border-top">
                    <td>Date-Time</td>
                    <td><?=$inputProfile['datetime']?></td>
                </tr>
                <tr class="border-top">
                    <td>Gender</td>
                    <td><?=$inputProfile['gender']?></td>
                </tr>
                <tr class="border-top">
                    <td>Coordinates</td>
                    <td><?=$inputProfile['coordinates']?></td>
                </tr>
                <tr class="border-top">
                    <td>system</td>
                    <td><?=$inputProfile['compatibility_system']?></td>
                </tr>
            </table>
        </div>

            <p class="mt-1">Disclaimer: The result is generated using 25 sample records and is intended only for demo purposes for Batch Marriage Matching.</p>
            <?php foreach ($result as $key => $dataCombination):?>
                <p class="font-weight-bold mb-0 mt-4"> Out of 25 Profiles matched <?= count($dataCombination) ?> are <span class="text-danger"> <?= $key ?> <span class="text-danger"></p>
                <table class="table table-bordered table-hover">
                    <tr class="bg-secondary text-white text-center">
                        <td class="text-center">Name</td>
                        <td class="text-center">Date-Time</td>
                        <td class="text-center">Location</td>
                        <td class="text-center">Coordinate</td>
                    </tr>

                    <?php foreach ($dataCombination as $uid => $data):?>
                        <tr>
                            <td> <?= $data['name']?> </td>
                            <td> <?= $data['datetime']?> </td>
                            <td> <?= $data['location']?> </td>
                            <td> <?= $data['coordinates']?> </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php endforeach; ?>

        <?php endif; ?>

        <section>
            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="" method="POST">


                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Name: </label>
                        <div class="col-sm-9 col-md-6 ">
                            <input type='text' name="name" class="form-control form-control-lg rounded-1" placeholder="Enter your name" value="<?= $inputProfile['name'] ?? null?>"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Date: </label>
                        <div class="col-sm-9 col-md-6 ">
                            <input type='datetime-local' name="datetime" class="form-control form-control-lg rounded-1" required="required" value="<?= $time_now->format('Y-m-d\TH:i')?>"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Place of birth:</label>
                        <div class="col-sm-9 col-md-6 ">
                            <input type='text' id="fin-location" name="location" autocomplete="off" class="form-control form-control-lg rounded-1 prokerala-location-input" placeholder="Place of birth" value="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Gender:</label>
                        <div class="col-sm-9 col-md-6 ">
                            <select name="gender" class="form-control form-control-lg rounded-1">
                                <option value="male" <?= 'male' === $gender ? 'selected' : ''?>> Male </option>
                                <option value="female" <?= 'female' === $gender ? 'selected' : ''?> > Female </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Compatibility System</label>
                        <div class="col-sm-9 col-md-6 ">
                            <select name="compatibility_system" class="form-control form-control-lg rounded-1">
                                <option value="guna-milan" <?= 'guna-milan' === $compatibilitySystem?>> Guna Milan </option>
                                <option value="kerala" <?= 'kerala' === $compatibilitySystem?>> Kerala </option>
                                <option value="tamil" <?= 'tamil' === $compatibilitySystem?>> Tamil </option>
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
