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
        <div class="section-inner bg-gradient-violet section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left mb-4 top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Astrology API Services</span>
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
            </div>
        </section>
    </div>
    <div class="container">
        <section>
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

        </section>
    </div>

</div>

<?php include 'common/footer.tpl.php'; ?>

</body>
</html>
