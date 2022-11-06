<?php

require __DIR__ . '/bootstrap.php';

$arGroupCalculators = [
    'Daily Panchang' => [
        'panchang',
        'auspicious-period',
        'inauspicious-period',
        'choghadiya',
        'tamil-panchang',
        'telugu-panchang',
        'hindu-panchang',
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
    'Numerology & Daily Horoscope' => [
        'numerology',
        'daily-horoscope',
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
        'horoscope-yoga',
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
