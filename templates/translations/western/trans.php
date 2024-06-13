<?php

declare(strict_types=1);

$translations = [
    'de' => [
        'Synastry Chart' => 'Synastrie Diagramm',
        'Synastry Aspect Chart' => 'Synastrie Aspekt Diagramm',
        'Synastry Planet Aspect' => 'Synastrie Planet Aspekt',
        'Primary Planet' => 'Hauptplanet',
        'Aspect' => 'Aspekt',
        'Secondary Planet' => 'Nebenplanet',
        'Orb' => 'Orb',
        'Major Aspects' => 'Hauptaspekte',
        'Minor Aspects' => 'Nebenaspekte',
        'Solar Return Chart' => 'Solar Return Diagramm',
        'Solar Return Aspect Chart' => 'Solar Return Aspekt Diagramm',
        'Solar Return Planet Positions' => 'Solar Return Planet Positionen',
        'Solar Return Date' => 'Solar Return Datum',
        'Planet' => 'Planet',
        'Longitude' => 'Längengrad',
        'Degree' => 'Grad',
        'House' => 'Haus',
        'Zodiac' => 'Sternzeichen',
        'Retrograding Planets' => 'Rückläufige Planeten',
        'Angles' => 'Winkel',
        'Solar Return House Cusps' => 'Solare Rückkehr Häuserspitzen',
        'Start Cusp' => 'Anfangsspitze',
        'End Cusp' => 'Endspitze',
        'List of Aspects' => 'Auflistung der Aspekte',
        'Declination Aspects' => 'Deklination Aspekte',
        'Solar Return Aspects' => 'Solare Rückkehr Aspekte',
        'Planet 1' => 'Planet 1',
        'Planet 2' => 'Planet 2',
        'Solar Return - Natal Aspects' => 'Solare Rückkehr - Geburtsaspekte',
        'Progression Chart' => 'Progressionen Diagramm',
        'Progression Aspect Chart' => 'Progression Aspektdiagramm',
        'Progression Year' => 'Progression Jahr',
        'Progression Date' => 'Progression datum',
        'Progression Planet Positions' => 'Progression Planetenpositionen',
        'Progression House Cusps' => 'Progression Häuserspitzen',
        'Progression Aspects' => 'Progression Aspekte',
        'Progression - Natal Aspects' => 'Progression - Geburtsaspekte',
        'Transit Chart' => 'Transitdiagramm',
        'Transit Aspect Chart' => 'Transit Aspektdiagramm',
        'Transit Planet Positions' => 'Transit Planetenpositionen',
        'Transit House Cusps' => 'Transit Häuserspitzen',
        'Transit Aspects' => 'Transit Aspekte',
        'Transit - Natal Aspects' => 'Transit - Geburtsaspekte',
        'Natal Chart' => 'Geburtshoroskop',
        'Natal Aspect Chart' => 'Geburtshoroskop Aspekte Diagramm',
        'Natal Planet Positions' => 'Geburtshoroskop Planetenpositionen',
        'Composite Chart' => 'Zusammengesetztes Diagramm',
        'Composite Aspect Chart' => 'Zusammengesetztes Aspektdiagramm',
        'Composite House Cusps' => 'Zusammengesetzte Häuserspitzen',
        'Composite Planet Position' => 'Zusammengesetzte Planetenposition',
        'Composite Angles' => 'Zusammengesetzte Winkel',
        'Composite Planet Aspect' => 'Zusammengesetzter Planetenaspekt',
        'Motion' => 'Bewegung',
        'Conjunction' => 'Konjunktion',
        'Opposition' => 'Opposition',
        'Square' => 'Quadrat',
        'Semi Square' => 'Halbquadrat',
        'Sesquiquadrate' => 'Anderthalbquadrat',
        'Trine' => 'Trigon',
        'Sextile' => 'Sextil',
        'Semi Sextile' => 'Halbsextil',
        'Quincunx' => 'Quinkunx',
        'Quintile' => 'Quintil',
        'Bi Quintile' => 'Biquintil',
        'Parallel' => 'Parallele',
        'Contra Parallel' => 'Kontraparallele',
        'Angle' => 'Winkel',
        'House Cusps' => 'Hausspitze',
        'Planet Aspects' => 'Planet Aspekte',
    ],
];

function __(string $key): string
{
    global $translations; // above variable
    global $la; // should pass from la value to template
    if ('en' === $la) {
        return $key;
    }

    return $translations[$la][$key] ?? $key;
}
