<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nakshatra Porutham | Astrology API Demo - Prokerala Astrology</title>
    <?php include 'common/style.tpl.php'; ?>
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/style.css">
    <link rel="stylesheet" href="<?=DEMO_BASE_URL?>/build/reports.css">
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
                        <span class="font-weight-thin">Nakshatra Porutham</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container prokerala-api-demo-container">
        <?php include 'common/helper.tpl.php'; ?>

        <?php if (!empty($result)): ?>
            <h3 class="text-black text-center">10 Poruthams and Your Compatibility</h3>
            <table class="mb-5 table table-bordered table-hover">
                <tr class="bg-secondary text-white">
                    <th>#</th>
                    <th>Porutham</th>
                    <?php if ('advanced' === $result_type): ?>
                        <th>Status</th>
                    <?php endif; ?>
                    <th class="text-center">Obtained Point</th>
                </tr>
                <?php foreach ($compatibilityResult['Matches'] as $idx => $data):?>
                    <tr><td><?=$idx + 1?></td><td><?=$data['name']?></td>
                        <?php if ('advanced' === $result_type):?>
                            <td>
                                <?='Good' === $data['poruthamStatus'] ? '<span class="text-success">Good</span>' :
                                    ('Bad' === $data['poruthamStatus'] ? '<span class="text-danger">Bad</span>' :
                                        '<span class="text-warning">Satisfactory</span>')?></td>
                            <td class="text-center"><?=$data['points']?></td>
                        <?php else:?>
                            <td class="text-center"><?=$data['hasPorutham'] ? 1 : 0?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <tr class="text-center">
                    <th colspan="<?='advanced' === $result_type ? 3 : 2?>">Total Points:</th>
                    <th><?=$compatibilityResult['ObtainedPoint']?> / <?=$compatibilityResult['maximumPoint']?></th>
                </tr>
            </table>

            <?php if ('advanced' === $result_type):?>
            <h3>Interpretation of 10 porutham</h3>
                <?php foreach ($compatibilityResult['Matches'] as $key => $data):?>
                    <h3><?=$data['name']?></h3>
                    <p><?=$data['description']?></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="mb-5 alert text-center alert-info p-5">
                <?=$compatibilityResult['message']['description']?>
            </div>

        <?php endif; ?>
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="" method="POST">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <legend class="col-form-label text-black py-4 text-xlarge">Enter Girl's Details</legend>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Girl Nakshatra</label>
                                    <div class="col-sm-9 col-md-6">
                                        <select name="girl_nakshatra" class="form-control form-control-lg rounded-1">
                                            <?php foreach ($nakshatraList as $nakshatraId => $nakshatra):?>
                                                <option value="<?=$nakshatraId?>" <?= $nakshatraId === $girl_nakshatra ? 'selected' : ''?>><?=$nakshatra?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Girl Nakshatra Pada</label>
                                    <div class="col-sm-9 col-md-6">
                                        <select name="girl_nakshatra_pada" class="form-control form-control-lg rounded-1">
                                            <?php foreach ($nakshatraPadaList as $nakshatraPadaId => $nakshatraPada):?>
                                                <option value="<?=$nakshatraPadaId?>" <?= $nakshatraPadaId === $girl_nakshatra_pada ? 'selected' : ''?>><?=$nakshatraPada?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <legend class="col-form-label text-black py-4 text-xlarge">Enter Boy's Details</legend>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Boy Nakshatra</label>
                                    <div class="col-sm-9 col-md-6">
                                        <select name="boy_nakshatra" class="form-control form-control-lg rounded-1">
                                            <?php foreach ($nakshatraList as $nakshatraId => $nakshatra):?>
                                                <option value="<?=$nakshatraId?>" <?= $nakshatraId === $boy_nakshatra ? 'selected' : ''?>><?=$nakshatra?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Boy Nakshatra Pada</label>
                                    <div class="col-sm-9 col-md-6">
                                        <select name="boy_nakshatra_pada" class="form-control form-control-lg rounded-1">
                                            <?php foreach ($nakshatraPadaList as $nakshatraPadaId => $nakshatraPada):?>
                                                <option value="<?=$nakshatraPadaId?>" <?= $nakshatraPadaId === $boy_nakshatra_pada ? 'selected' : ''?>><?=$nakshatraPada?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Result Type: </label>
                            <div class="col-sm-9 col-md-6 ">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="result_type" id="result_type1" value="basic" <?='basic' === $result_type ? 'checked' : ''?>>
                                    <label class="form-check-label" for="result_type1">Basic</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="result_type" id="result_type2" value="advanced" <?='advanced' === $result_type ? 'checked' : ''?>>
                                    <label class="form-check-label" for="result_type2">Advanced</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning btn-submit">Get Result</button>
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
