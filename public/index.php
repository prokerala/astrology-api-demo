<?php

require __DIR__ . '/bootstrap.php';

$arGroupCalculators = [
    'Daily Panchang' => [
        'panchang',
        'auspicious-period',
        'inauspicious-period',
        'choghadiya',
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
    ],
    'Marriage Matching' => [
        'kundli-matching',
        'nakshatra-porutham',
        'thirumana-porutham',
        'porutham',
        'papasamyam-check',
    ],
];
include DEMO_BASE_DIR . '/templates/home.tpl.php';
