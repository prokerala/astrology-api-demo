<?php
declare(strict_types=1);

include __DIR__ . '/ashtakavarga-table.tpl.php';

use Prokerala\Api\Astrology\Result\Horoscope\AshtakavargaResult;
use Prokerala\Api\Astrology\Result\Horoscope\SarvashtakavargaResult;
use Prokerala\Api\Astrology\Result\Planet;

/**
 * @var int                                                                    $planetId
 * @var string                                                                 $chart
 * @var string                                                                 $tpl_view
 * @var AshtakavargaResult|SarvashtakavargaResult                              $result
 * @var list<array{chart: string, planet: string, result: AshtakavargaResult}> $ar_ashtakavarga
 */
?>

<?php if ('sarvashtakavarga' === $tpl_view): ?>

    <h3>Sarvashtagavarga</h3>
    <div class="d-flex justify-content-center">
        <?= $chart ?>
    </div>
    <?php $sarvashtavarga = $result->getSarvashtakavarga()->getPrastara() ?>

    <?= createAshtakavargaTable($sarvashtavarga->getHouses(), $sarvashtavarga->getScore(), true) ?>

    <h3 class="text-center">Ashtakavarga Chart and Table</h3>
    <?php foreach ($ar_ashtakavarga as $ashtakavarga): ?>
        <h4 class="text-center text-large"><?= $ashtakavarga['planet'] ?> Ashtakavarga</h4>
        <div class="d-flex justify-content-center">
            <?= $ashtakavarga['chart'] ?>
        </div>

        <?php $ashtakavarga = $ashtakavarga['result']->getAshtakavarga()->getPrastara() ?>

        <?= createAshtakavargaTable($ashtakavarga->getHouses(), $ashtakavarga->getScore()) ?>
    <?php endforeach; ?>

<?php else: ?>

    <h3><?= Planet::PLANET_LIST[$planetId]?> Ashtakavarga</h3>
    <div class="d-flex justify-content-center">
        <?= $chart ?>
    </div>
    <?php $ashtakavarga = $result->getAshtakavarga()->getPrastara() ?>
    <?= createAshtakavargaTable($ashtakavarga->getHouses(), $ashtakavarga->getScore()) ?>

<?php endif; ?>
