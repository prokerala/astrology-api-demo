<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kaal Sarp Dosha | Prokerala API</title>

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
                        <span class="font-weight-thin">Kaal Sarp Dosha</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container demo-container">
        <?php if (!empty($result)): ?>
            <div class="alert p-4 text-center <?=$kaalSarpDoshaResult['has_kaal_sarp_dosha'] ? 'alert-danger' : 'alert-success'?>">
                <?=$kaalSarpDoshaResult['description']?>
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
            <section>

                <div class="card contact-form-wrapper box-shadow mx-auto rounded-2 mb-5">
                    <form class="p-5 text-default"  action="kaal-sarp-dosha.php" method="POST">
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
