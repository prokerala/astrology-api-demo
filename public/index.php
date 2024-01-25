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
        'sudarshana-chakra',
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
        'transit-chart',
        'progression-chart',
        'solar-return-chart',
        'synastry-chart',
        'composite-chart',
    ],
];

include DEMO_BASE_DIR . '/templates/home.tpl.php';
