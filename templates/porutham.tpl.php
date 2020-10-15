<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Porutham | Prokerala API</title>

    <link rel="stylesheet" href="/build/style.css">
</head>

<body>
<?php include 'common/header.tpl.php'; ?>
<?php $alertClass = [
   'Excellent' => 'alert-success',
   'Good' => 'alert-info',
   'Average' => 'alert-warning',
   'Bad' => 'alert-danger',
   ];?>
<div class="main-content">
    <div class="header-1 section-rotate bg-section-secondary">
        <div class="section-inner bg-gradient-violet section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Porutham</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container demo-container">
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
                    <?php if(in_array($idx, ['nakshatra', 'rasi'], true)):?>
                        <?php foreach ($info as $item => $itemVale):?>
                            <?php if($item == 'id') { continue;}?>
                            <tr>
                                <td><b><?=$item?></b></td>
                                <td><?=$itemVale?></td>
                                <td><?=$compatibilityResult['boyInfo'][$idx][$item]?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach; ?>
            </table>
            <div class="alert alert-info mb-5 p-4 text-center <?=$alertClass[$compatibilityResult['status']]?>">
                <?=$compatibilityResult['description']?> (<?=$compatibilityResult['totalPoint']?> / 10)
            </div>
            <h3 class="text-black text-center">10 Poruthams and Your Compatibility</h3>
            <table class="mb-5 table table-bordered <?= ('advanced' === $result_type) ? 'text-small' : ''?>">
                <tr>
                    <th>#</th>
                    <th>Porutham</th>
                    <?php if($result_type === 'advanced'): ?>
                        <th>Status</th>
                    <?php endif; ?>
                    <th class="text-center">Obtained Point</th>
                </tr>
                <?php foreach ($compatibilityResult['Matches'] as $idx => $data):?>
                    <tr><td><?=$idx+1?></td><td><?=$data['name']?></td>
                        <?php if($result_type === 'advanced'):?>
                            <td>
                                <?=$data['poruthamStatus'] === 'Good' ? '<span class="text-success">Good</span>' :
                                    ($data['poruthamStatus'] === 'Satisfactory' ? '<span class="text-warning">Satisfactory</span>' :
                                        '<span class="text-danger">Not Satisfactory</span>')?></td>
                            <td class="text-center"><?=$data['points'] ? 1 : 0?></td>
                        <?php else:?>
                            <td class="text-center"><?=$data['hasPorutham'] ? 1 : 0?></td>
                        <?php endif;?>
                    </tr>
                <?php endforeach; ?>
                <tr class="text-center text-large">
                    <th colspan="<?=$result_type === 'advanced' ? 3 : 2?>">Total Points:</th>
                    <th><?=$compatibilityResult['totalPoint']?> / <?=$compatibilityResult['maximumPoint']?></th>
                </tr>
            </table>

            <?php if ('advanced' === $result_type):?>
                <h3>Interpretation of 10 porutham</h3>
                <?php foreach ($compatibilityResult['Matches'] as $key => $data):?>
                    <h3><?=$data['name']?></h3>
                    <p><?=$data['description']?></p>
                <?php endforeach; ?>
            <?php endif; ?>

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
                <form class="p-5 text-default"  action="porutham.php" method="POST">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 pr-md-0 col-form-label">Ayanamsa</label>
                                <div class="col-md-8 pl-md-0">
                                    <select name="ayanamsa" class="form-control form-control-lg rounded-1">
                                        <option value="1" <?=$ayanamsa == 1 ? 'selected' :''?>>Lahiri</option>
                                        <option value="3" <?=$ayanamsa == 3 ? 'selected' :''?>>Raman</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 pr-md-0 col-form-label">System</label>
                                <div class="col-md-8 pl-md-0">
                                    <select name="system" class="form-control form-control-lg rounded-1">
                                        <option value="kerala" <?=$system == 'kerala' ? 'selected' :''?>>Kerala</option>
                                        <option value="tamil" <?=$system == 'tamil' ? 'selected' :''?>>Tamil</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'common/porutham-form.tpl.php'; ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-md-4 col-form-label  text-xs-left">Result Type: </label>
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
