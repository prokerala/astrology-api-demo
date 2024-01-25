<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Planet Position | Astrology API Demo - Prokerala Astrology</title>
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
                        <span class="font-weight-thin">Planet Relationship</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <h3 class="text-center">Planet Relationship</h3>
            <h3>Naisargika Maitri Table: </h3>
                <p>The subsequent table illustrates the Naisargika Maitri, representing the inherent or natural relationships among the planets:</p>
            <div class="table-responsive">
                <table class="table table-bordered table-sm t-sm">
                    <tr>
                        <th>Planets</th>
                        <?php foreach ($planet_order as $planet): ?>
                            <th><?= $planet?></th>
                        <?php endforeach; ?>

                    </tr>
                    <?php foreach ($planet_order as $planet_one_id => $planet_one): ?>
                        <tr>
                            <th><?= $planet_one?></th>
                            <?php foreach ($planet_order as $planet_two_id => $planet_two): ?>
                                <?php
                                foreach ($planetRelationships->getNaturalRelationship() as $relation) {
                                    if ($relation->getFirstPlanet()->getId() === $planet_one_id
                                        && $relation->getSecondPlanet()->getId() === $planet_two_id
                                    ) {
                                        $relationship = $relation->getRelation();
                                    }
                                }
                                ?>
                                <td>
                                    <?= 'No Relation' === $relationship ? '--' : $relationship ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <h3>Tatkaala Maitri Table: </h3>
                <p>The table below shows the temporary relationships among the planets, known as Tatkaala Maitri or Temporary Relationship:</p>
            <div class="table-responsive">
                <table class="table table-bordered table-sm t-sm">
                    <tr>
                        <th>Planets</th>
                        <?php foreach ($planet_order as $planet): ?>
                            <th><?= $planet?></th>
                        <?php endforeach; ?>

                    </tr>
                    <?php foreach ($planet_order as $planet_one_id => $planet_one): ?>
                        <tr>
                            <th><?= $planet_one?></th>
                            <?php foreach ($planet_order as $planet_two_id => $planet_two): ?>
                                <?php
                                foreach ($planetRelationships->getTemporalRelationship() as $relation) {
                                    if ($relation->getFirstPlanet()->getId() === $planet_one_id
                                        && $relation->getSecondPlanet()->getId() === $planet_two_id
                                    ) {
                                        $relationship = $relation->getRelation();
                                    }
                                }
                                ?>
                                <td>
                                    <?= 'No Relation' === $relationship ? '--' : $relationship ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <h3>Panchada Maitri Table:</h3>
                <p>The ensuing table displays the compound relationship among the planets, referred to as the Panchada Maitri or Five-Fold relationship. This calculation involves the combination of both Naisargika and Tatkaala Maitri:</p>
            <div class="table-responsive">
                <table class="table table-bordered table-sm t-sm">
                    <tr>
                        <th>Planets</th>
                        <?php foreach ($planet_order as $planet): ?>
                            <th><?= $planet?></th>
                        <?php endforeach; ?>

                    </tr>
                    <?php foreach ($planet_order as $planet_one): ?>
                        <tr>
                            <th><?= $planet_one?></th>
                            <?php foreach ($planet_order as $planet_two): ?>
                                <?php foreach ($planetRelationships->getCompoundRelationship() as $relation): ?>
                                    <?php if ($relation->getFirstPlanet()->geti() === $planet_one  && $relation->getSecondPlanet()->getName() === $planet_two): ?>
                                        <td>  <?= $planet_one === $planet_two ? '--' : $relation->getRelation(); ?> </td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
        <section>
            <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                <form class="p-5 text-default"  action="planet-relationship.php" method="POST">
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
