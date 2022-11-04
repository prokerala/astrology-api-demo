<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Auspicious Period Astrology API Demo</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">
    <style>
        .table{
            max-width: 800px;
            margin: auto;
        }
    </style>
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
                        <span class="font-weight-thin">Daily Horoscope</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container prokerala-api-demo-container">

        <?php include 'common/helper.tpl.php'; ?>

        <section>
            <?php if ($result):?>
            <div>
                <h3><?=$result->getDailyHoroscopePrediction()->getSignName()?> : <?=$result->getDailyHoroscopePrediction()->getDate()->format('d M, Y')?></h3>
                <nav class="mb-3">
                    <ul class="nav nav-tabs" >
                        <li class="nav-item">
                            <a class="nav-link <?=('yesterday' === $day) ? 'active' : ''?>"  href="?sign=<?=strtolower($signName)?>&day=yesterday">Yesterday</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=('today' === $day) ? 'active' : ''?>" aria-current="page" href="?sign=<?=strtolower($signName)?>&day=today">Today</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=('tomorrow' === $day) ? 'active' : ''?>" href="?sign=<?=strtolower($signName)?>&day=tomorrow">Tommorow</a>
                        </li>
                    </ul>
                </nav>

                <p><?=$result->getDailyHoroscopePrediction()->getPrediction()?></p>
            </div>
            <?php endif?>
            <br>
            <br>
            <div class="row mb-5 api-calculators-list">
                <?php foreach ($signs as $signKey => $sign):?>
                    <div class="col-6 col-sm-4 col-md-2 mb-4">
                        <div class="api-calculators-list-card p-2 shadow text-center">
                            <a href="daily-horoscope.php?sign=<?=$signKey?>">
                                <div class="api-calculators-list-image demo-api-calculators-list-image m-4 p-4">
                                    <img class="img-fluid" src="<?=DEMO_BASE_URL?>/assets/img/icon/sign/<?=$signKey?>.png">
                                </div>
                                <span class="feature-card-title b"><?=$sign?></span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </div>
</div>
<?php include 'common/footer.tpl.php'; ?>
</body>
</html>
