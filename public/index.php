<?php

require __DIR__ . '/bootstrap.php';

$arGroupCalculators = [
    'Numerology & Daily Horoscope' => [
        'numerology',
        'daily-horoscope',
    ],
    'Daily Panchang' => [
        'panchang',
        'auspicious-period',
        'inauspicious-period',
        'choghadiya',
        'hindu-panchang',
        'tamil-panchang',
        'telugu-panchang',
        'malayalam-panchang',
        'calendar',
        'anandadi-yoga',
        'chandra-bala',
        'tara-bala',
        'ritu',
        'solstice',
        'hora',
        'disha-shool',
        'auspicious-yoga',
    ],
    'PDF Report' => [
        'pdf-report',
    ],
    'Horoscope' => [
        'birth-details',
        'kundli',
        'mangal-dosha',
        'kaal-sarp-dosha',
        'sade-sati',
        'papasamyam',
        'planet-position',
        'chart',
        'dasha-periods',
        'yoga-details',
    ],
    'Marriage Matching' => [
        'kundli-matching',
        'nakshatra-porutham',
        'thirumana-porutham',
        'porutham',
        'papasamyam-check',
    ],
    'Western Astrology' => [
        'natal-chart',
        'natal-aspect-chart',
        'natal-planet-position',
        'transit-chart',
        'transit-aspect-chart',
//        'transit-planet-position',
        'progression-chart',
        'progression-aspect-chart',
//        'progression-planet-position',
        'solar-return-chart',
        'solar-return-aspect-chart',
//        'solar-return-planet-position',
        'synastry-chart',
        'synastry-aspect-chart',
//        'synastry-planet-aspect',
        'composite-chart',
        'composite-aspect-chart',
//        'composite-planet-aspect',
    ],
];

include DEMO_BASE_DIR . '/templates/home.tpl.php';
