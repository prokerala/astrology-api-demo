<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Papa samyam | Prokerala API</title>

    <link rel="stylesheet" href="/build/style.css">

</head>

<body>
<?php include 'common/header.tpl.php'; ?>

<div class="main-content">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Papa samyam</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container demo-container">
        <?php if (!empty($result)): ?>
            <h2 class="text-center text-black">Papasamyam Details</h2>
            <table class="table table-bordered text-small table-responsive-sm table-striped">
                <thead>
                <tr><th rowspan="2">Papa Points</th><th colspan="2">From Ascendant</th><th colspan="2">From Moon</th><th colspan="2">From Venus
                    </th></tr>
                <tr><th>Position</th><th>Papam</th><th>Position</th><th>Papam</th><th>Position</th><th>Papam</th></tr>
                </thead>
                <?php $arPapaPlanets = ['Mars', 'Saturn', 'Sun', 'Rahu']; ?>
                <?php $arPapaFromPlanets = ['Ascendant', 'Moon', 'Venus']; ?>
                <?php foreach ($arPapaPlanets as $papaPlanet => $papaPlanetName):?>
                    <tr><th><?=$papaPlanetName?></th>
                    <?php foreach ($arPapaFromPlanets as $fromPlanet => $fromPlanetName):?>
                        <td><?=$papasamyamResult['papaPlanet'][$fromPlanet]['planetDosha'][$papaPlanet]['position']?></td>
                        <td><?=$papasamyamResult['papaPlanet'][$fromPlanet]['planetDosha'][$papaPlanet]['hasDosha'] ? 1 : 0?></td>
                    <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                <tr><th colspan="7" class="text-center">Total Papa Points : <?=$papasamyamResult['total_points']?></th> </tr>
            </table>
        <?php elseif (!empty($errors)):?>
            <?php foreach ($errors as $error):?>
                <div class="alert alert-danger text-small">
                    <?=$error->title; ?>:
                    <?=$error->detail?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="papasamyam.php" method="POST">
                        <?php include 'common/basic-form.tpl.php'; ?>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning">Get Result</button>
                            <input type="hidden" name="submit" value="1">
                        </div>
                    </form>
                </div>
            </section>

    </div>
</div>


<?php include 'common/footer.tpl.php'; ?>

</body>
</html>
