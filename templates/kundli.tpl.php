<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kundli | Prokerala API</title>

    <link rel="stylesheet" href="/build/style.css">

</head>

<body>
<?php include 'common/header.tpl.php'; ?>

<div class="main-content demo-container">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Kundli</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($result)): ?>

            <?php $nakshatra_details = $kundliResult['nakshatraDetails']; ?>
            <table class="table table-bordered mb-5">
                <tr class="table-warning"><td colspan="2" class="text-center">Nakshatra Details</td></tr>
                <tr><td>Nakshatra :</td><td><?=$nakshatra_details['nakshatraName']?></td></tr>
                <tr><td>Date & Time</td><td><?=$nakshatra_details['nakshatraStart']->format('d-M h:i A')?> to <br>
                        <?=$nakshatra_details['nakshatraEnd']->format('d-M h:i A')?></td></tr>
                <tr><td>Longitude :</td><td><?=$nakshatra_details['nakshatraLongitude']?></td></tr>
                <tr><td>Nakshatra Pada</td><td><?=$nakshatra_details['nakshatraPada']?></td></tr>
                <tr><td>Chandra Rasi</td><td><?=$nakshatra_details['chandraRasi']['name']?></td></tr>
                <tr><td>Soorya Rasi</td><td><?=$nakshatra_details['sooryaRasi']['name']?></td></tr>
                <tr><td>Zodiac</td><td><?=$nakshatra_details['zodiac']['name']?></td></tr>
                <tr class="table-warning"><td colspan="2" class="text-center">Additional Info:</td></tr>
                <?php foreach ($nakshatra_details['additionalInfo'] as $key => $data):?>
                    <tr><td><?= ucwords($key)?></td><td><?=$data?></td></tr>
                <?php endforeach; ?>
            </table>

            <h3 class="text-black">Yoga Details</h3>
            <?php foreach ($kundliResult['yogas'] as $key => $data):?>
                <span class="font-weight-regular text-black"><?= ucwords($key)?></span>
                <p class="text-black"><?=$data?></p>
            <?php endforeach; ?>
            <div class="alert p-4 text-center p-5 <?=$kundliResult['mangalDosha']['has_mangal_dosha'] ? 'alert-danger' : 'alert-success'?>" >
                <?=$kundliResult['mangalDosha']['description']?>
            </div>

        <?php elseif (!empty($errors)):?>
            <?php foreach ($errors as $key => $error):?>
                <div class="alert alert-danger text-small">
                    <?php if($key == 'message'):?>
                        <?=$error?>
                    <?php else:?>
                        <?=$error->title ?? ''; ?>:
                        <?=$error->detail ?? ''?>
                    <?php endif;?>
                </div>
            <?php endforeach; ?>
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


    </div>
</div>


<?php include 'common/footer.tpl.php'; ?>

</body>
</html>
