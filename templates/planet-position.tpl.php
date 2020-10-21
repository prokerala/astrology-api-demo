<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Planet Position | Astrology API Demo - Prokerala Astrology</title>

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
                        <span class="font-weight-thin">Planet Position</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <h3 class="text-center">Planet Positions</h3>
            <table class="table table-bordered table-hover table-responsive-sm">
                <tr class="bg-secondary text-white">
                    <th>Planets</th>
                    <th>Position</th>
                    <th>Degree</th>
                    <th>Rasi</th>
                    <th>Rasi Lord</th>
                </tr>
                <?php foreach ($planetPositionResult as $planet):?>
                    <tr>
                        <td><?=$planet['name']?></td>
                        <td><?=$planet['position']?></td>
                        <td><?=$planet['degree']?></td>
                        <td><?=$planet['rasi']?></td>
                        <td><?=$planet['rasiLord'] . ' (' . $planet['rasiLordEn'] . ') '?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="planet-position.php" method="POST">
                        <?php include 'common/basic-form.tpl.php'; ?>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning">Get Result</button>
                            <input type="hidden" name="submit" value="1">
                        </div>
                    </form>
                </div>
            </section>
        <?php include 'common/calculator-list.tpl.php'; ?>


    </div>
</div>


<?php include 'common/footer.tpl.php'; ?>

</body>
</html>
