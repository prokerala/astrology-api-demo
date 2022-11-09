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
];

include DEMO_BASE_DIR . '/templates/home.tpl.php';
