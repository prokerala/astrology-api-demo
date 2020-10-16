<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Auspicious Period | Prokerala API</title>

    <link rel="stylesheet" href="/build/style.css">
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
        <div class="section-inner bg-gradient-violet section-radius-min">
        </div>
        <div class="container top-header-wrapper">
            <div class="row my-auto">
                <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 text-lg-left top-header-text-content">
                    <h2 class="text-white mb-5">
                        <span class="font-weight-thin">Auspicious Period</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container demo-container">
        <?php if (!empty($result)): ?>
            <h2 class="text-center text-black">Auspicious Timing</h2>
            <table class="table table-bordered text-large text-center table-hover">
                 <tr class="bg-secondary text-white"><th>Auspicious Yogas</th><th>Time</th></tr>
                <?php foreach ($auspiciousPeriodResult as $key => $data):?>
                    <tr class="border-top">
                        <td><?= $data['name']?></td>
                        <td>
                            <?php foreach ($data['period'] as $value):?>
                                <?=$value['start']->format('h:i:A')?> to <?=$value['end']->format('h:i:A')?> <br>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endforeach?>
            </table>
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
            <section>
                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="auspicious-period.php" method="POST">
                        <?php include 'common/basic-form.tpl.php'; ?>
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
