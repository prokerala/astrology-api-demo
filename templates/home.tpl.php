<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Astrology API Demo</title>
    
    <link rel="stylesheet" href="/build/style.css">
    <style>
        .api-calculators-list-card {
            height:175px;
            line-height: 2.5rem;
        }
        .api-calculators-list-image {
            background: linear-gradient(#8430de, #6643c9);
        }
    </style>
</head>

<body>
<?php include 'common/header.tpl.php'; ?>

<div class="main-content">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left mb-4 top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Astrology API Demo</span>
                    </h2>
                    <p class="text-white mb-5 font-weight-regular">From basic birth charts and daily astrology to detailed horoscope & kundli matching, all your astrology content needs delivered at one place</p>
                    <div class="mb-5">
                        <a class="btn btn-warning rounded" href="/login">TRY IT FOR FREE </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ml-auto d-block text-center top-header-image-wrapper">
        <img alt="Demo" class="top-header-image" src="/assets/img/sample-home.png">
    </div>
    <div class="text-black">
        <section>
            <div class="container feauters-wrapper text-center mb-5">
                <h2 class="text-black mb-5">
                    <span class="font-weight-thin"></span>
                </h2>
                <p class="mb-5">Prokerala astrology API offers a complete array of astrology features empowering you to develop a full fledged astrology website or mobile app in no time. </p>
                <div class="text-center">
                    <a class="btn btn-primary" href="https://github.com/prokerala/astrology-api-demo" target="_blank">Download Source Code</a>
                </div>
            </div>
        </section>
    </div>
    <div class="container">
        <section>
            <div class="mb-5">
                <?php foreach($arGroupCalculators as $group_name => $calculators): ?>
                    <h3><?=$group_name?> Calculators</h3>
                    <div class="row mb-5 api-calculators-list">
                            <?php foreach ($calculators as $calculator):?>
                                <div class="col-6 col-sm-4 col-md-2 mb-4">
                                    <div class="api-calculators-list-card p-2 shadow text-center">
                                        <a href="<?=$samples[$calculator]['url']?>">
                                            <div class="api-calculators-list-image m-4">
                                                <img class="img-fluid" src="<?=$samples[$calculator]['image']?>">
                                            </div>
                                            <span class="feature-card-title b"><?=$samples[$calculator]['title']?></span>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </section>
    </div>

</div>

<?php include 'common/footer.tpl.php'; ?>
</body>
</html>
