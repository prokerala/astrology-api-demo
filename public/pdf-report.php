<?php
declare(strict_types=1);
use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Report\Service\PersonalReport;
use Prokerala\Api\Report\Service\CompatibilityReport;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

$submit = $_POST['submit'] ?? 0;
$sample_name = 'pdf-report';
$report_mode = isset($_POST['report_mode']) ? $_POST['report_mode'] : (isset($_GET['report_mode']) ? $_GET['report_mode'] : 'personal-report');

if (!in_array($report_mode, ['personal-report', 'compatibility-report'])) {
    $report_mode = 'personal-report';
}

$timezone = 'Asia/Kolkata';
$chartType = 'north-indian';
if (isset($_POST['submit'])) {

    if ($report_mode === 'personal-report') {
        $firstName = $_POST['first_name'];
        $middleName = $_POST['middle_name'];
        $lastName = $_POST['last_name'];
        $gender = $_POST['gender'];
        $chartType = $_POST['chart_type'];
    } else {
        $girlFirstName = $_POST['girl_first_name'];
        $girlMiddleName = $_POST['girl_middle_name'];
        $girlLastName = $_POST['girl_last_name'];
        $boyFirstName = $_POST['boy_first_name'];
        $boyMiddleName = $_POST['boy_middle_name'];
        $boyLastName = $_POST['boy_last_name'];
    }
    $reportName = $_POST['report_name'] ?: 'Sample Report';
    $report = $_POST['report'];
    $reportCaption = $_POST['report_caption'];
}

$result = [];
$errors = [];

$reportTypes = [
    'personal-report' => [
        'mangal-dosha-report' => [
            ['name' => 'birth-details'],
            ['name' => 'chart', 'options' => ['chart_style' => $chartType]],
            ['name' => 'planet-position'],
            ['name' => 'mangal-dosha'],
        ],
        'personal-report' => [
            ['name' => 'birth-details'],
            ['name' => 'chart', 'options' => ['chart_style' => $chartType]],
            ['name' => 'planet-position'],
            ['name' => 'mangal-dosha', 'options' => ['chart_style' => $chartType]],
            ['name' => 'yoga-details'],
            ['name' => 'kaal-sarp-dosha', 'options' => ['chart_style' => $chartType]],
            ['name' => 'sade-sati', 'options' => ['chart_style' => $chartType]],
            ['name' => 'shodasavarga-chart', 'options' => ['chart_style' => $chartType]],
            ['name' => 'dasa-periods'],
            ['name' => 'papa-dosha', 'options' => ['chart_style' => $chartType]],
        ]
    ],
    'compatibility-report' => [
        'kundli-matching' => [
            ['name' => 'birth-details', 'options' => ['chart_style' => 'north-indian']],
            ['name' => 'mangal-dosha'],
            ['name' => 'kundli-matching'],
        ],
        'tamil-porutham' => [
            ['name' => 'birth-details', 'options' => ['chart_style' => 'south-indian']],
            ['name' => 'mangal-dosha'],
            ['name' => 'porutham-tamil'],
        ],
        'kerala-porutham' => [
            ['name' => 'birth-details', 'options' => ['chart_style' => 'south-indian']],
            ['name' => 'mangal-dosha'],
            ['name' => 'porutham-kerala'],
        ]
    ],
];

if ($submit) {
    try {

        if ($report_mode === 'personal-report') {
            $method = new PersonalReport($client);
            $input = [
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'datetime' => '1809-02-12T20:00:00+05:30',
                'coordinates' => '22.6757521,88.0495361',
                'place' => 'London, UK',
                'gender' => $gender,
            ];
        } else {
            $method = new CompatibilityReport($client);
            $input = [
                'first_person' => [
                    'first_name' => $girlFirstName,
                    'middle_name' => $girlMiddleName,
                    'last_name' => $girlLastName,
                    'datetime' => '2019-06-13T08:00:00+05:30',
                    'coordinates' => '22.6757521,88.0495361',
                    'place' => 'London, UK',
                    'gender' => 'male',
                ],
                'second_person' => [
                    'first_name' => $boyFirstName,
                    'middle_name' => $boyMiddleName,
                    'last_name' => $boyLastName,
                    'datetime' => '2015-02-20T22:00:00+05:30',
                    'coordinates' => '22.6757521,88.0495361',
                    'place' => 'London, UK',
                    'gender' => 'female',
                ],
            ];
        }

        $options = [
            'modules' => $reportTypes[$report_mode][$report],
            'template' => [
                'style' => 'basic',
                'footer' => '<a href="https://www.prokerala.com">prokerala.com</a> | 📧 support@prokerala.com | Call Now: 1800 425 0053',
            ],
            'report' => [
                'name' => $reportName,
                'caption' => $reportCaption,
                'brand_name' => 'Prokerala',
            ],
        ];



        $result = $method->process($input, $options);

        header('Content-Type: application/pdf');
        echo $result;
        exit;

    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
        $errors['message'] = 'ERROR: You have exceeded your quota allocation for the day';
    } catch (RateLimitExceededException $e) {
        $errors['message'] = 'ERROR: Rate limit exceeded. Throttle your requests.';
    } catch (AuthenticationException $e) {
        $errors = ['message' => $e->getMessage()];
    } catch (Exception $e) {
        $errors = ['message' => "API Request Failed with error {$e->getMessage()}"];
    }
}

$apiCreditUsed = $client->getCreditUsed();
include DEMO_BASE_DIR . '/templates/pdf-report.tpl.php';


//if (true) {
//    $input = [
//        'first_person' => [
//            'first_name' => 'Ram',
//            'last_name' => 'Kumar',
//            'datetime' => '1996-02-12T15:19:00+05:30',
//            'coordinates' => '10.214747,78.097626',
//            'place' => 'London, UK',
//            'gender' => 'male',
//        ],
//        'second_person' => [
//            'first_name' => 'Sita',
//            'last_name' => 'Devi',
//            'datetime' => '200-19-19T10:09:00+05:30',
//            'coordinates' => '10.214747,78.097626',
//            'place' => 'London, UK',
//            'gender' => 'female',
//        ]
//    ];
//    $options = [
//        'modules' => [
//            ['name' => 'kundli-matching-info'],
//            ['name' => 'advanced-kundli-matching-info'],
//            ['name' => 'basic-porutham-tamil'],
//            ['name' => 'advanced-porutham-tamil'],
//            ['name' => 'basic-porutham-kerala'],
//            ['name' => 'advanced-porutham-kerala'],
//        ],
//        'report' => [
//            'name' => 'Horoscope Compatibility',
//            'caption' => 'Your comprehensive horoscope matching report',
//            'brand_name' => 'Astro Services',
//        ],
//    ];
//} else {
//    $input = [
//        'first_name' => 'Vishnu',
//        'last_name' => 'Sharma',
//        'datetime' => '2004-02-12T15:19:21+05:30',
//        'coordinates' => '10.214747,78.097626',
//        'place' => 'London, UK',
//        'gender' => 'male',
//    ];
//    $options = [
//        'modules' => [
//            ['name' => 'mangal-dosha'],
//            ['name' => 'advanced-mangal-dosha'],
//            ['name' => 'birth-details'],
//            ['name' => 'yoga-details'],
//            ['name' => 'advanced-yoga-details'],
//            ['name' => 'kaal-sarp-dosha'],
//            ['name' => 'planet-position'],
//            ['name' => 'sade-sati'],
//            ['name' => 'advanced-sade-sati'],
//            ['name' => 'papasamyam'],
//            ['name' => 'chart', 'options' => ['chart_style' => 'north-indian']],
//        ],
//        'report' => [
//            'name' => 'Super Horoscope',
//            'caption' => 'Your complete horoscope',
//            'brand_name' => 'Astro Services',
//        ],
//    ];
//}
//
//
//$query = [
//    'input' => $input,
//    'options' => $options + [
//            'template' => [
//                'style' => 'basic',
//                'footer' => '<a href="https://www.example.com">Your Brand Name</a> | 📧 support@example.com | Call Now: +91-9876543210',
//            ]
//        ],
//];
//
//echo http_build_query($query);
//echo json_encode($query);
//echo var_export($query, true);