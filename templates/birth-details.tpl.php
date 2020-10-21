<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vedic Astrology Birth Details | Astrology API Demo - Prokerala Astrology</title>

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
                        <span class="font-weight-thin">Birth Details</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container demo-container">
        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>
            <table class="table table-bordered">
                <tr class="table-success"><th colspan="2" class="text-center">Nakshatra is <?=$nakshatra_details['nakshatra']->getName()?></th></tr>
                <tr><td>Nakshatra Pada</td><td><?=$nakshatra_details['nakshatra']->getPada()?></td></tr>
                <tr><td>Nakshatra Lord</td><td><?=$nakshatra_details['nakshatra']->getLord()?></td></tr>
                <tr><td>Chandra Rasi</td><td><?=$nakshatra_details['chandra_rasi']->getName()?></td></tr>
                <tr><td>Chandra Rasi Lord</td><td><?=$nakshatra_details['chandra_rasi']->getLord() . '(' . $nakshatra_details['chandra_rasi']->getLord()->getVedicName() . ')'?></td></tr>
                <tr><td>Soorya Rasi</td><td><?=$nakshatra_details['soorya_rasi']->getName()?></td></tr>
                <tr><td>Soorya Rasi Lord</td><td><?=$nakshatra_details['soorya_rasi']->getLord() . '(' . $nakshatra_details['soorya_rasi']->getLord()->getVedicName() . ')'?></td></tr>
                <tr><td>Zodiac</td><td><?=$nakshatra_details['zodiac']->getName()?></td></tr>
                <tr class="table-warning"><td colspan="2" class="text-center">Additional Info:</td></tr>
                <?php foreach ($nakshatra_additional_info as $key => $data):?>
                    <tr><td><?= $key?></td><td><?=$data?></td></tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="" method="POST">
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
