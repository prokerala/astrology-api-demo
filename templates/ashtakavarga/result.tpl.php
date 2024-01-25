<?php
declare(strict_types=1);

include __DIR__ . '/ashtakavarga-table.tpl.php';

use Prokerala\Api\Astrology\Result\Horoscope\AshtagavargaResult;
use Prokerala\Api\Astrology\Result\Horoscope\SarvashtakavargaResult;
use Prokerala\Api\Astrology\Result\Planet;

/**
 * @var int                                                                    $planetId
 * @var string                                                                 $chart
 * @var string                                                                 $tpl_view
 * @var AshtagavargaResult|SarvashtakavargaResult                              $result
 * @var list<array{chart: string, planet: string, result: AshtagavargaResult}> $ar_ashtakavarga
 */
?>

<?php if ('sarvashtakavarga' === $tpl_view): ?>

    <h3>Sarvashtagavarga</h3>
    <div class="d-flex justify-content-center">
        <?= $chart ?>
    </div>
    <?php $sarvashtavarga = $result->getSarvashtakavarga() ?>

    <?= createAshtagavargaTable($sarvashtavarga->getHouses(), $sarvashtavarga->getScore(), true) ?>

    <span class="text-large item-">Ashtagavarga Chart and Table</span>
    <?php foreach ($ar_ashtakavarga as $ashtakavarga): ?>
        <span class="text-large"><?= $ashtakavarga['planet'] ?> Ashtagavarga</span>
        <div class="d-flex justify-content-center">
            <?= $ashtakavarga['chart'] ?>
        </div>

        <?php $ashtakavarga = $ashtakavarga['result']->getAshtakavarga() ?>
        <?= createAshtagavargaTable($ashtakavarga->getHouses(), $ashtakavarga->getScore()) ?>
    <?php endforeach; ?>

<?php else: ?>

    <h2><?= Planet::PLANET_LIST[$planetId]?> Ashtagavarga</h2>
    <div class="d-flex justify-content-center">
        <?= $chart ?>
    </div>
    <?php $ashtakavarga = $result->getAshtakavarga() ?>
    <?= createAshtagavargaTable($ashtakavarga->getHouses(), $ashtakavarga->getScore()) ?>

<?php endif; ?>
