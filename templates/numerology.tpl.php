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
                        <span class="font-weight-thin">Numerology Demos</span>
                    </h2>
<!--                    <p class="text-white">Auspicious period shows results like Abhijit Muhurat, Amrit Kaal and Brahma Muhurat. <a class="text-warning" href="https://www.prokerala.com/astrology/panchangam/" target="_blank">Read More..</a></p>-->
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">

        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>

            <?php include "numerology-result/{$calculatorValue}.tpl.php";

            ?>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="numerology.php" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">First Name:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type="text" name="firstName" class="form-control form-control-lg rounded-1" placeholder="Enter First Name" value="Akhil" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Middle Name:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type="text" name="middleName" class="form-control form-control-lg rounded-1" placeholder="Enter Middle Name" value="Abin" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Last Name:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type="text" name="lastName" class="form-control form-control-lg rounded-1" placeholder="Enter Last Name" value="Vishnu" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Date: </label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type='date' name="datetime" class="form-control form-control-lg rounded-1" required="required" value="<?=$datetime->format('Y-m-d')?>"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Additional Vowel:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="additionalVowel" value="1">
                                        Use additional vowel `yw` in calculation
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Refrence Year:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type="number" name="referenceYear" class="form-control form-control-lg rounded-1" placeholder="Enter Reference Year" value="2022" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">System: </label>
                            <div class="col-sm-9 col-md-6 ">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="system" class="fin-numerology-system" id="optionsRadios1" value="pythagorean" checked>
                                        Pythagorean
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="system" class="fin-numerology-system" id="optionsRadios2" value="chaldean">
                                        Chaldean
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Calculator: </label>
                            <div class="col-sm-9 col-md-6 ">
                                <select name="calculatorName" id="fin-calculator-list" class="form-control form-control-lg rounded-1">
                                    <option>Select Calculator</option>
                                    <?php foreach ($calculators[$system] as $calculatorValue => $calculatorName):?>
                                        <option value="<?=$calculatorValue?>"><?=$calculatorName?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div id="form-hidden-fields">

                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning btn-submit ">Get Result</button>
                            <input type="hidden" name="submit" value="1">
                        </div>
                    </form>
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
