<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Prokerala API Demo</title>

    <link rel="stylesheet" href="/build/style.css">

</head>

<body>
<?php include 'common/header.tpl.php'; ?>

<div class="main-content">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-pink section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Sample implementation of astrology services</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="ml-auto d-block text-center top-header-image-wrapper">
        <img alt="Demo" class="top-header-image" src="/assets/img/sample-home.png" style="width:320px">
    </div>
    <div class="container">
        <section>
            <p>Astrology predictions, calculations, reports and remedies available on Prokerala.com is broadly based on Indian Predictive Astrology. All the astrological calculations are based on scientific equations and is not based on any published almanac. Therefore, comparisons between the calculations made by Prokerala.com and those published in almanacs are absolutely unwarranted and Prokerala.com shall not entertain disputes on differences arising out of such comparisions.</p>
            <div class="text-center mb-5">
                <div class="row list-element-grid">
                    <?php foreach ($samples as $value):?>
                    <div class="col-4 col-sm-3 col-lg-2 mb-5">
                        <a href="<?=$value['url']?>">
                            <span class="feature-card-image"><img src="<?=$value['image']?>"></span>
                            <span class="feature-card-title"><?=$value['title']?></span>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <p>
                Though all efforts have been made to ensure the accuracy of all published reports and calculations, we do not rule out the possibility of any unexpected errors. Therefore, Prokerala.com cannot be held responsible for the decisions that may be taken by anyone based on this report. Prokerala.com assumes no liability for any decisions made based on output from our calculations or reports. The reports or remedies should not be used as substitute for advice, programs, or treatment that you would normally receive from a licensed professional, such as a financial or legal advisor, doctor, psychiatrist etc... Information, forecasts, predictions, reports and remedies provided by Prokerala.com should be taken strictly as guidelines and suggestions.
            </p>
            <p>
                By utilising and accessing Prokerala.com astrology section and/or by requesting and/or receiving astrological interpretations and/or advice either through the site or affiliates of the company, you agree to release Prokerala.com from any and all liability with regard to the contents of the site and/or advice received.
            </p>
        </section>
    </div>
</div>

<?php include 'common/footer.tpl.php'; ?>

</body>
</html>
