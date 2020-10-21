<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kundli Matching | Astrology API Demo - Prokerala Astrology</title>

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
                        <span class="font-weight-thin">Kundli Matching</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <section>
            <?php if (!empty($result)): ?>
                <h3>Birth Details</h3>
                <table class="table table-bordered text-small mb-5">
                    <tr>
                        <th>#</th>
                        <th>Details of Girl</th>
                        <th>Details of Boy</th>
                    </tr>
                    <tr>
                        <th>Date Of Birth</th>
                        <td><?=$girl_dob->format('F d, Y')?></td>
                        <td><?=$boy_dob->format('F d, Y')?></td>
                    </tr>
                    <?php foreach ($compatibilityResult['girlInfo'] as $idx => $info): ?>
                        <?php if (in_array($idx, ['nakshatra', 'rasi'], true)):?>
                            <?php foreach ($info as $item => $itemVale):?>
                                <?php if ('id' === $item) {continue;}?>
                                <?php if('lord' === $item):?>
                                    <tr>
                                        <td><b><?=$item?></b></td>
                                        <td><?="{$itemVale['vedicName']} ({$itemVale['name']})"?></td>
                                        <td><?="{$compatibilityResult['boyInfo'][$idx][$item]['vedicName']} ({$compatibilityResult['boyInfo'][$idx][$item]['name']})"?></td>
                                    </tr>
                                <?php else:?>
                                    <tr>
                                        <td><b><?=$item?></b></td>
                                        <td><?=$itemVale?></td>
                                        <td><?=$compatibilityResult['boyInfo'][$idx][$item]?></td>
                                    </tr>
                                <?php endif;?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>

                <h3>Guna Milan Details</h3>
                <table class="mb-5 table table-bordered text-small table-responsive-sm">
                    <tr>
                        <th>#</th>
                        <th>Guna</th>
                        <th>Girl</th>
                        <th>Boy</th>
                        <?php if ('advanced' === $result_type):?>
                            <th>Maximum Points</th>
                            <th>Obtained Points</th>
                        <?php endif; ?>
                    </tr>
                    <?php if ('advanced' === $result_type):?>
                        <?php foreach ($compatibilityResult['gunaMilan']['guna'] as $data):?>
                            <tr>
                                <td><?=$data['id']?></td>
                                <td><b><?=$data['name']?> Koot</b></td>
                                <td><?=$data['girlKoot']?></td>
                                <td><?=$data['boyKoot']?></td>
                                <td><?=$data['maximumPoints']?></td>
                                <td><?=$data['obtainedPoints']?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <?php $count = 1; foreach ($compatibilityResult['girlInfo']['koot'] as $guna => $data): ?>
                            <?php $guna_koot = preg_replace('/(?<!\ )[A-Z]/', ' $0', $guna);
                            $guna_koot = ucwords($guna_koot); ?>
                            <tr>
                                <td><?=$count?></td>
                                <td><b><?=$guna_koot?> Koot</b></td>
                                <td><?=$data?></td>
                                <td><?=$compatibilityResult['boyInfo']['koot'][$guna]?></td>
                            </tr>
                            <?php ++$count; endforeach; ?>
                    <?php endif;?>
                    <tr class="text-large">
                        <?php if ('advanced' === $result_type):?>
                            <th colspan="4" class="text-center">Total Guna Milan Points :</th>
                            <th><?=$compatibilityResult['gunaMilan']['maximumPoints']?></th>
                            <th><?=$compatibilityResult['gunaMilan']['totalPoints']?></th>
                        <?php else:?>
                            <th colspan="4" class="text-center">Total Guna Milan Points :
                                <?=$compatibilityResult['gunaMilan']['totalPoints']?> / <?=$compatibilityResult['gunaMilan']['maximumPoints']?></th>
                        <?php endif; ?>
                    </tr>
                </table>
                <?php if ('advanced' === $result_type):?>
                    <h3 class="text-black">Guna Milan Detailed Interpretation</h3>
                    <?php $count = 1; foreach ($compatibilityResult['gunaMilan']['guna'] as  $koot): ?>
                        <p class="text-black"><?=$koot['id']?>. <?=$koot['name']?> Koot</p>
                        <p class="text-black"><?=$koot['description']?></p>
                        <?php ++$count; endforeach; ?>

                    <p>Girl Mangal Dosha Details</p>
                    <p class="alert <?=(($compatibilityResult['girlMangalDoshaDetails']['hasMangalDosha']) ? 'alert-danger' : 'alert-success')?>">
                        <?=$compatibilityResult['girlMangalDoshaDetails']['description']?>
                    </p>

                    <p>Boy Mangal Dosha Details</p>
                    <p class="alert <?=(($compatibilityResult['boyMangalDoshaDetails']['hasMangalDosha']) ? 'alert-danger' : 'alert-success')?>">
                        <?=$compatibilityResult['boyMangalDoshaDetails']['description']?>
                    </p>
                <?php endif; ?>

                <div class="mb-5 alert text-center <?=(('bad' === $compatibilityResult['message']['type']) ? 'alert-danger' : 'alert-success')?>">
                    <?=$compatibilityResult['message']['description']?>
                </div>
            <?php elseif (!empty($errors)):?>
                <?php foreach ($errors as $key => $error):?>
                    <div class="alert alert-danger text-small">
                        <?php if ('message' === $key):?>
                            <?=$error?>
                        <?php else:?>
                            <?=$error->title ?? ''; ?>:
                            <?=$error->detail ?? ''?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
                <div class="card sample-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="kundli-matching.php" method="POST">

                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label ">Result Type: </label>
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
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-4 col-form-label ">Ayanamsa</label>
                            <div class="col-sm-9 col-md-6">
                                <select name="ayanamsa" class="form-control form-control-lg rounded-1">
                                    <option value="1" <?=1 == $ayanamsa ? 'selected' : ''?>>Lahiri</option>
                                    <option value="3" <?=3 == $ayanamsa ? 'selected' : ''?>>Raman</option>
                                    <option value="5" <?=5 == $ayanamsa ? 'selected' : ''?>>KP</option>
                                </select>
                            </div>
                        </div>
                        <?php include 'common/porutham-form.tpl.php'; ?>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning">Get Result</button>
                            <input type="hidden" name="submit" value="1">
                        </div>
                    </form>
                </div>
            <?php include 'common/calculator-list.tpl.php'; ?>

        </section>
    </div>
</div>


<?php include 'common/footer.tpl.php'; ?>

</body>
</html>
