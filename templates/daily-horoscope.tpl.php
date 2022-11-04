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
            <br>
            <br>
            <br>
            <br>
            <?php if ($resultToday):?>
            <div>
                <h3><?=$resultToday->getDailyHoroscopePrediction()->getSignName()?></h3>
                <nav>
                    <ul class="nav nav-pills nav-fill" >
                        <li class="nav-item">
                            <?php if('yesterday' === $dateSelected):?>
                            <a class="nav-link active"  href="?sign=<?=strtolower($signName)?>&date=yesterday">Yesterday</a>
                            <?php else:?>
                            <a class="nav-link"  href="?sign=<?=strtolower($signName)?>&date=yesterday">Yesterday</a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if('today' === $dateSelected):?>
                                <a class="nav-link active" aria-current="page" href="?sign=<?=strtolower($signName)?>&date=today">Today</a>
                            <?php else:?>
                                <a class="nav-link" aria-current="page" href="?sign=<?=strtolower($signName)?>&date=today">Today</a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if('tommorow' === $dateSelected):?>
                                <a class="nav-link active" href="?sign=<?=strtolower($signName)?>&date=tommorow">Tommorow</a>
                            <?php else: ?>
                                <a class="nav-link" href="?sign=<?=strtolower($signName)?>&date=tommorow">Tommorow</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <?php if('yesterday' === $dateSelected):?>
                        <p><?=$resultYesterday->getDailyHoroscopePrediction()->getPrediction()?></p>
                    <?php elseif('tommorow' === $dateSelected):?>
                        <p><?=$resultTommorow->getDailyHoroscopePrediction()->getPrediction()?></p>
                    <?php else:?>
                        <p><?=$resultToday->getDailyHoroscopePrediction()->getPrediction()?></p>
                    <?php endif?>
                </nav>
            </div>
            <?php endif?>
            <br>
            <br>
            <div class="row">
                <?php foreach ($signs as $signKey => $sign):?>
                    <div class="col-6 col-sm-4 col-md-2 mb-4">
                        <a href="/demo/daily-horoscope.php?sign=<?=$signKey?>">
                            <div class="shadow text-center">
                                <?=$sign?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </div>
</div>

<script>
    var numerologyCalculators = <?=json_encode($calculators)?>;

    [...document.getElementsByClassName('fin-numerology-system')].forEach(function (elem) {
        elem.addEventListener('change', function () {
            console.log('html');
            let calculators = numerologyCalculators[this.value];
            let html = '<option>Select Calculator</option>';
            console.log(calculators);
            for (var i in calculators) {
                html += '<option value="'+ i +'">'+ calculators[i] +'</option>';
            };
            document.getElementById('fin-calculator-list').innerHTML = html;
        });
    });
</script>
<?php include 'common/footer.tpl.php'; ?>
</body>
</html>
