<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\NakshatraProfile;
use Prokerala\Api\Astrology\Service\ThirumanaPorutham;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/nakshatra-list.php';

$client = include __DIR__ . '/../client.php';

$girl_nakshatra = 0;
$girl_nakshatra_pada = 2;
$boy_nakshatra = 13;
$boy_nakshatra_pada = 3;

$result_type = 'basic';
$submit = $_POST['submit'] ?? 0;
$ayanamsa = 1;

$result = [];
$errors = [];

if (isset($_POST['submit'])) {
    $girl_nakshatra = $_POST['girl_nakshatra'];
    $girl_nakshatra_pada = $_POST['girl_nakshatra_pada'];
    $boy_nakshatra = $_POST['boy_nakshatra'];
    $boy_nakshatra_pada = $_POST['boy_nakshatra_pada'];
    $result_type = $_POST['result_type'];
    try {
        $advanced = 'advanced' === $result_type ? true : false;
        $girl_profile = new NakshatraProfile($girl_nakshatra, $girl_nakshatra_pada);
        $boy_profile = new NakshatraProfile($boy_nakshatra, $boy_nakshatra_pada);

        $thirumana_porutham = new ThirumanaPorutham($client);

        $thirumana_porutham->process($girl_profile, $boy_profile, $advanced);
        $result = $thirumana_porutham->getResult();

        $compatibilityResult = [];

        $compatibilityResult['maximumPoint'] = $result->getMaximumPoint();
        $compatibilityResult['ObtainedPoint'] = $result->getObtainedPoint();

        if ($advanced) {
            $fields = [
                'dinaPorutham',
                'ganaPorutham',
                'mahendraPorutham',
                'streeDhrirghamPorutham',
                'yoniPorutham',
                'rasiPorutham',
                'rasiLordPorutham',
                'rajjuPorutham',
                'vedaPorutham',
                'vashyaPorutham',
                'nadiPorutham',
                'varnaPorutham',
            ];
            foreach ($fields as $field) {
                $functionName = 'get' . ucwords($field);
                $poruthamResult = $result->{$functionName}();
                foreach (['hasPorutham', 'point', 'description'] as $value) {
                    $functionName = 'get' . ucwords($value);
                    $compatibilityResult['porutham'][$field][$value] = $poruthamResult->{$functionName}();
                }
            }
        }
    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
    } catch (RateLimitExceededException $e) {
    }
}



include __DIR__ . '/../templates/thirumana-porutham.tpl.php';
