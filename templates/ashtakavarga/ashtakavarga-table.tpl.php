<?php

declare(strict_types=1);
use Prokerala\Api\Astrology\Result\Horoscope\Astagavarga\AshtakavargaChartHouse;

/** @param  AshtakavargaChartHouse[] $houses */
function createAshtagavargaTable(array $houses, int $totalScore, bool $isSarvashtavarga = false): string
{
    $ascendant = !$isSarvashtavarga ? '<th>Ascendant</th>' : '';
    $table_body = '';
    $planet_score = [];
    foreach ($houses as $house) {
        $table_body .= "<tr><th>{$house->getRasi()->getName()}</th>";
        foreach ($house->getPlanets() as $planet) {
            $planet_id = $planet->getPlanet()->getId();
            if (isset($planet_score[$planet_id])) {
                $planet_score[$planet_id] += $planet->getScore();
            } else {
                $planet_score[$planet_id] = $planet->getScore();
            }
            $table_body .= "<th>{$planet->getScore()}</th>";
        }
        $table_body .= "<th>{$house->getScore()}</th>";
        $table_body .= '</tr>';
    }
    $table_body .= '<tr><th>Score</th>';
    foreach ($planet_score as $score) {
        $table_body .= "<td>{$score}</td>";
    }
    $table_body .= "<td>{$totalScore}</td></tr>";

    return <<<TABLE
        <div class="mt-3">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Rasi / Planet</th>
                    <th>Sun</th>
                    <th>Moon</th>
                    <th>Mercury</th>
                    <th>Venus</th>
                    <th>Mars</th>
                    <th>Jupiter</th>
                    <th>Saturn</th>
                    {$ascendant}
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                {$table_body}
            </tbody>
            </table>
        </div>
        TABLE;
}
