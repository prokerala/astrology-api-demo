<?php

declare(strict_types=1);

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Service\BatchCompatibility;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

require __DIR__ . '/bootstrap.php';

require __DIR__ . '/datelimiter.php';

$time_now = new DateTimeImmutable();

$inputGirls = [
    'profile' => [
        'name' => 'Sachin Ramesh',
        'datetime' => '1990-11-01T09:00:00+01:00',
        'coordinates' => '12,20',
        'gender' => 'male',
    ],
    'match_profiles' => [
        [
            'name' =>'Aadhya Sharma',
            'datetime'   => '1996-04-12T10:32:41+05:30',
            'coordinates'=> '13.08,80.27',
            'gender' => 'female',
            'location'   => 'Chennai',
        ],
        [
            'name' =>'Myra Reddy',
            'datetime'   => '2004-09-25T18:15:09+05:30',
            'coordinates'=> '12.96,80.19',
            'gender' => 'female',
            'location'   => 'Chennai',
        ],
        [
            'name' =>'Anaya Chatterjee',
            'datetime'   => '2012-02-03T05:44:58+05:30',
            'coordinates'=> '9.97,76.28',
            'gender' => 'female',
            'location'   => 'Kochi',
        ],
        [
            'name' =>'Siya Mehta',
            'datetime'   => '2001-11-20T21:09:12+05:30',
            'coordinates'=> '9.92,76.25',
            'gender' => 'female',
            'location'   => 'Kochi',
        ],
        [
            'name' =>'Ira Deshmukh',
            'datetime'   => '2017-08-14T03:22:49+05:30',
            'coordinates'=> '28.66,77.23',
            'gender' => 'female',
            'location'   => 'Delhi',
        ],
        [
            'name' =>'Tanisha Iyer',
            'datetime'   => '1999-05-17T12:55:30+05:30',
            'coordinates'=> '28.61,77.21',
            'gender' => 'female',
            'location'   => 'Delhi',
        ],
        [
            'name' =>'Kashvi Bhatia',
            'datetime'   => '2008-01-29T16:40:05+05:30',
            'coordinates'=> '13.04,80.22',
            'gender' => 'female',
            'location'   => 'Chennai',
        ],
        [
            'name' =>'Prisha Kulkarni',
            'datetime'   => '1998-07-03T09:11:44+05:30',
            'coordinates'=> '10.02,76.32',
            'gender' => 'female',
            'location'   => 'Kochi',
        ],
        [
            'name' =>'Vritika Tiwari',
            'datetime'   => '2019-10-11T23:58:37+05:30',
            'coordinates'=> '28.70,77.18',
            'gender' => 'female',
            'location'   => 'Delhi',
        ],
        [
            'name' =>'Navya Rajput',
            'datetime'   => '2003-03-27T06:05:18+05:30',
            'coordinates'=> '9.95,76.23',
            'gender' => 'female',
            'location'   => 'Kochi',
        ],
        [
            'name' =>'Saanvi Joshi',
            'datetime'   => '2014-12-02T14:44:10+05:30',
            'coordinates'=> '13.02,80.25',
            'gender' => 'female',
            'location'   => 'Chennai',
        ],
        [
            'name' =>'Avni Chauhan',
            'datetime'   => '1989-06-06T19:33:29+05:30',
            'coordinates'=> '28.59,77.32',
            'gender' => 'female',
            'location'   => 'Delhi',
        ],
        [
            'name' =>'Trisha Malhotra',
            'datetime'   => '2006-08-21T02:18:53+05:30',
            'coordinates'=> '13.10,80.29',
            'gender' => 'female',
            'location'   => 'Chennai',
        ],
        [
            'name' =>'Riddhima Pandey',
            'datetime'   => '2011-01-15T11:28:41+05:30',
            'coordinates'=> '9.98,76.31',
            'gender' => 'female',
            'location'   => 'Kochi',
        ],
        [
            'name' =>'Vanya Solanki',
            'datetime'   => '1994-10-09T07:45:16+05:30',
            'coordinates'=> '28.68,77.28',
            'gender' => 'female',
            'location'   => 'Delhi',
        ],
        [
            'name' =>'Dhriti Saini',
            'datetime'   => '2009-03-14T11:22:45-04:00',
            'coordinates'=> '40.71,-74.00',
            'gender' => 'female',
            'location'   => 'New York',
        ],
        [
            'name' =>'Mahika Gokhale',
            'datetime'   => '1998-11-27T04:55:18-05:00',
            'coordinates'=> '40.73,-74.01',
            'gender' => 'female',
            'location'   => 'New York',
        ],
        [
            'name' =>'Aarini Mishra',
            'datetime'   => '2015-07-02T19:10:37-04:00',
            'coordinates'=> '40.75,-73.99',
            'gender' => 'female',
            'location'   => 'New York',
        ],
        [
            'name' =>'Kiara Jaiswal',
            'datetime'   => '2003-01-19T23:40:09-05:00',
            'coordinates'=> '40.70,-73.94',
            'gender' => 'female',
            'location'   => 'New York',
        ],
        [
            'name' =>'Charvi Khatri',
            'datetime'   => '2012-10-30T08:15:27-04:00',
            'coordinates'=> '40.72,-74.02',
            'gender' => 'female',
            'location'   => 'New York',
        ],
        [
            'name' =>'Hemangi Patil',
            'datetime'   => '2007-05-14T10:42:31+01:00',
            'coordinates'=> '51.50,-0.12',
            'gender' => 'female',
            'location'   => 'London',
        ],
        [
            'name' =>'Yashasvi Nair',
            'datetime'   => '1999-11-03T21:18:09+00:00',
            'coordinates'=> '51.52,-0.10',
            'gender' => 'female',
            'location'   => 'London',
        ],
        [
            'name' =>'Shanaya Bhandari',
            'datetime'   => '2016-08-27T04:55:43+01:00',
            'coordinates'=> '51.49,-0.08',
            'gender' => 'female',
            'location'   => 'London',
        ],
        [
            'name' =>'Lavanya Bhargava',
            'datetime'   => '2002-01-09T15:22:17+00:00',
            'coordinates'=> '51.51,-0.14',
            'gender' => 'female',
            'location'   => 'London',
        ],
        [
            'name' =>'Revati Srinivasan',
            'datetime'   => '2013-03-21T07:33:56+00:00',
            'coordinates'=> '51.53,-0.11',
            'gender' => 'female',
            'location'   => 'London',
        ],
    ],
    'compatibility_system' => 'guna-milan',
];


$inputBoys = [
    'profile' => [
        'name' => 'TEST',
        'datetime' => '1990-11-01T09:00:00+01:00',
        'coordinates' => '12,20',
        'gender' => 'female',
    ],
    'match_profiles' => [
        [
            'name' => 'Aarav Sharma',
            'datetime'   => '1996-04-12T10:32:41+05:30',
            'coordinates'=> '13.08,80.27',
            'gender' => 'male',
            'location'   => 'Chennai',
        ],
        [
            'name' => 'Vivaan Kulkarni',
            'datetime'   => '2004-09-25T18:15:09+05:30',
            'coordinates'=> '12.96,80.19',
            'gender' => 'male',
            'location'   => 'Chennai',
        ],
        [
            'name' => 'Ishaan Deshmukh',
            'datetime'   => '2012-02-03T05:44:58+05:30',
            'coordinates'=> '9.97,76.28',
            'gender' => 'male',
            'location'   => 'Kochi',
        ],
        [
            'name' => 'Reyansh Mehta',
            'datetime'   => '2001-11-20T21:09:12+05:30',
            'coordinates'=> '9.92,76.25',
            'gender' => 'male',
            'location'   => 'Kochi',
        ],
        [
            'name' => 'Shivansh Chatterjee',
            'datetime'   => '2017-08-14T03:22:49+05:30',
            'coordinates'=> '28.66,77.23',
            'gender' => 'male',
            'location'   => 'Delhi',
        ],
        [
            'name' => 'Krishnan Iyer',
            'datetime'   => '1999-05-17T12:55:30+05:30',
            'coordinates'=> '28.61,77.21',
            'gender' => 'male',
            'location'   => 'Delhi',
        ],
        [
            'name' => 'Arjit Bhargava',
            'datetime'   => '2008-01-29T16:40:05+05:30',
            'coordinates'=> '13.04,80.22',
            'gender' => 'male',
            'location'   => 'Chennai',
        ],
        [
            'name' => 'Devansh Bhatia',
            'datetime'   => '1998-07-03T09:11:44+05:30',
            'coordinates'=> '10.02,76.32',
            'gender' => 'male',
            'location'   => 'Kochi',
        ],
        [
            'name' => 'Advik Reddy',
            'datetime'   => '2019-10-11T23:58:37+05:30',
            'coordinates'=> '28.70,77.18',
            'gender' => 'male',
            'location'   => 'Delhi',
        ],
        [
            'name' => 'Pranav Joshi',
            'datetime'   => '2003-03-27T06:05:18+05:30',
            'coordinates'=> '9.95,76.23',
            'gender' => 'male',
            'location'   => 'Kochi',
        ],
        [
            'name' => 'Ritvik Malhotra',
            'datetime'   => '2014-12-02T14:44:10+05:30',
            'coordinates'=> '13.02,80.25',
            'gender' => 'male',
            'location'   => 'Chennai',
        ],
        [
            'name' => 'Vedanth Chauhan',
            'datetime'   => '1989-06-06T19:33:29+05:30',
            'coordinates'=> '28.59,77.32',
            'gender' => 'male',
            'location'   => 'Delhi',
        ],
        [
            'name' => 'Atharv Tiwari',
            'datetime'   => '2006-08-21T02:18:53+05:30',
            'coordinates'=> '13.10,80.29',
            'gender' => 'male',
            'location'   => 'Chennai',
        ],
        [
            'name' => 'Samarth Rajput',
            'datetime'   => '2011-01-15T11:28:41+05:30',
            'coordinates'=> '9.98,76.31',
            'gender' => 'male',
            'location'   => 'Kochi',
        ],
        [
            'name' => 'Nirvaan Gokhale',
            'datetime'   => '1994-10-09T07:45:16+05:30',
            'coordinates'=> '28.68,77.28',
            'gender' => 'male',
            'location'   => 'Delhi',
        ],
        [
            'name' => 'Lakshay Khatri',
            'datetime'   => '2009-03-14T11:22:45-04:00',
            'coordinates'=> '40.71,-74.00',
            'gender' => 'male',
            'location'   => 'New York',
        ],
        [
            'name' => 'Harit Srinivasan',
            'datetime'   => '1998-11-27T04:55:18-05:00',
            'coordinates'=> '40.73,-74.01',
            'gender' => 'male',
            'location'   => 'New York',
        ],
        [
            'name' => 'Tanmay Saini',
            'datetime'   => '2015-07-02T19:10:37-04:00',
            'coordinates'=> '40.75,-73.99',
            'gender' => 'male',
            'location'   => 'New York',
        ],
        [
            'name' => 'Aayush Patil',
            'datetime'   => '2003-01-19T23:40:09-05:00',
            'coordinates'=> '40.70,-73.94',
            'gender' => 'male',
            'location'   => 'New York',
        ],
        [
            'name' => 'Vihan Nair',
            'datetime'   => '2012-10-30T08:15:27-04:00',
            'coordinates'=> '40.72,-74.02',
            'gender' => 'male',
            'location'   => 'New York',
        ],
        [
            'name' => 'Raghav Pandey',
            'datetime'   => '2007-05-14T10:42:31+01:00',
            'coordinates'=> '51.50,-0.12',
            'gender' => 'male',
            'location'   => 'London',
        ],
        [
            'name' => 'Kiaan Mishra',
            'datetime'   => '1999-11-03T21:18:09+00:00',
            'coordinates'=> '51.52,-0.10',
            'gender' => 'male',
            'location'   => 'London',
        ],
        [
            'name' => 'Omkar Jaiswal',
            'datetime'   => '2016-08-27T04:55:43+01:00',
            'coordinates'=> '51.49,-0.08',
            'gender' => 'male',
            'location'   => 'London',
        ],
        [
            'name' => 'Siddhant Bhandari',
            'datetime'   => '2002-01-09T15:22:17+00:00',
            'coordinates'=> '51.51,-0.14',
            'gender' => 'male',
            'location'   => 'London',
        ],
        [
            'name' => 'Yugendra Solanki',
            'datetime'   => '2013-03-21T07:33:56+00:00',
            'coordinates'=> '51.53,-0.11',
            'gender' => 'male',
            'location'   => 'London',
        ],
    ],
    'compatibility_system' => 'guna-milan',
];

$submit = $_POST['submit'] ?? 0;
$la = $_POST['la'] ?? 'en';
$ayanamsa = 1;
$sample_name = 'birth-details';

$gender = 'male';
$compatibilitySystem = 'compatibility_system';

function isempty(mixed $name)
{

}

if (isset($_POST['submit'])) {

    $gender = $gender = $_POST['gender'] ?? 'male';
    $input = $gender === 'male' ? $inputGirls : $inputBoys;
    $dateTime = $_POST['datetime'] ?? $input['profile']['datetime'];
    $coordinates = $_POST['coordinates'] ?? $input['profile']['coordinates'];
    $compatibilitySystem = $_POST['compatibility_system'] ?? $input['compatibility_system'];

    $input['profile']['datetime'] = $dateTime;
    $input['profile']['coordinates'] = $coordinates;
    $input['profile']['gender'] = $gender;
    $input['compatibility_system'] = $compatibilitySystem;
    $profileDateTime = new DateTimeImmutable($input['profile']['datetime']);
    $input['profile']['datetime'] = $profileDateTime;
    $tz = $profileDateTime->getTimezone();
    $locationCoordinates = explode(',', $input['profile']['coordinates']);
    $input['profile']['coordinates'] = new Location((float)$locationCoordinates[0], (float)$locationCoordinates[1], 0, $tz);
    $input['profile']['gender'] = $gender ?? $input['profile']['gender'];


    $inputProfile['name'] = empty($_POST['name']) ? 'Not Given' : $_POST['name'];
    $inputProfile['datetime'] = $profileDateTime->format('d M, Y, h:i A');
    $inputProfile['gender'] = $gender;
    $inputProfile['coordinates'] = $_POST['coordinates'];
    $inputProfile['compatibility_system'] = $compatibilitySystem;

    $result = [];
    $errors = [];
}

if ($submit) {
    $time_now = $profileDateTime;
    foreach ($input['match_profiles'] as $index => $matchProfile) {
        $matchDateTime = new DateTimeImmutable($matchProfile['datetime']);
        $tz = $matchDateTime->getTimezone();
        $locationCoordinates = explode(',', $matchProfile['coordinates']);
        $location = new Location((float)$locationCoordinates[0], (float)$locationCoordinates[1], 0, $tz);
        $input['match_profiles'][$index]['datetime'] = $matchDateTime;
        $input['match_profiles'][$index]['coordinates'] = $location;
        $input['match_profiles'][$index]['gender'] = 'male' === $input['profile']['gender'] ? 'female' : 'male';
    }
}


if ($submit) {
    try {
        $method = new BatchCompatibility($client);
        $result = $method->process($input);
        $getBatchCompatibility = $result->getBatchCompatibility();


        $result = [];
        foreach ($getBatchCompatibility as $index => $batchCompatibility) {
            $result[$batchCompatibility->getStatus()][] = [
                'name' => $input['match_profiles'][$index]['name'],
                'datetime' => $input['match_profiles'][$index]['datetime']->format('d M, Y, h:i A'),
                'location' => $input['match_profiles'][$index]['location'],
                'coordinates' => $input['match_profiles'][$index]['coordinates']->getCoordinates(),
                'status' => $batchCompatibility->getStatus(),
                'description' => $batchCompatibility->getDescription(),
            ];
        }
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

include DEMO_BASE_DIR . '/templates/batch-compatibility.tpl.php';
