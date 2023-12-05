<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <h2 class="text-white mb-5">
    <?php if (!empty($result)): ?>
        <title><?=$calculatorName?> | Numerology Calculator</title>
    <?php else: ?>
        <title>Numerology Calculator | API Demo</title>
    <?php endif; ?>
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
                        <?php if (!empty($result)): ?>
                            <span class="font-weight-thin"><?=$calculatorName?></span>
                        <?php else: ?>
                            <span class="font-weight-thin">Numerology Calculator</span>
                        <?php endif; ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">

        <?php include 'common/helper.tpl.php'; ?>
        <?php if (!empty($result)): ?>
            <?php include "numerology-result.tpl.php"; ?>
        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="numerology.php" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">First Name:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type="text" name="firstName" class="form-control form-control-lg rounded-1" placeholder="Enter First Name" value="<?=$firstName?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Middle Name:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type="text" name="middleName" class="form-control form-control-lg rounded-1" placeholder="Enter Middle Name" value="<?=$middleName?>" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Last Name:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type="text" name="lastName" class="form-control form-control-lg rounded-1" placeholder="Enter Last Name" value="<?=$lastName?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Date of Birth: </label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type='date' name="date" value="<?=$datetime->format('Y-m-d')?>" class="form-control form-control-lg rounded-1" required="required"/>
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
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Reference Year:</label>
                            <div class="col-sm-9 col-md-6 ">
                                <input type="number" name="referenceYear" class="form-control form-control-lg rounded-1" placeholder="Enter Reference Year" value="2022" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">System: </label>
                            <div class="col-sm-9 col-md-6 ">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="system" class="fin-numerology-system" id="optionsRadios1" value="pythagorean" <?=$system === 'pythagorean' ? 'checked' : ''?> >
                                        Pythagorean
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="system" class="fin-numerology-system" id="optionsRadios2" value="chaldean" <?=$system === 'chaldean' ? 'checked' : ''?>>
                                        Chaldean
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Calculator: </label>
                            <div class="col-sm-9 col-md-6 ">
                                <select name="calculatorName" id="fin-calculator-list" class="form-control form-control-lg rounded-1">
                                    <?php foreach ($calculators[$system] as $calculatorValue => $calculatorDetails):?>
                                        <option <?=$selectedCalculator === $calculatorValue ? 'selected' : ''?> value="<?=$calculatorValue?>"><?=$calculatorDetails['name']?></option>
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
        <?php include 'common/calculator-list.tpl.php'; ?>
    </div>
</div>

<script>
    var numerologyCalculators = <?=json_encode($calculators)?>;

    [...document.getElementsByClassName('fin-numerology-system')].forEach(function (elem) {
        elem.addEventListener('change', function () {
            let calculators = numerologyCalculators[this.value];
            let html = '';
            for (var i in calculators) {
                html += '<option value="'+ i +'">'+ calculators[i]['name'] +'</option>';
            };
            document.getElementById('fin-calculator-list').innerHTML = html;
        });
    });
</script>
<?php include 'common/footer.tpl.php'; ?>
</body>
</html>
