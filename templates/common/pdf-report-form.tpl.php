<?php

use Prokerala\Api\Astrology\Result\Planet;

?>
<ul class="nav nav-tabs mb-6 nav-fill">
    <li class="nav-item">
        <a class="nav-link p-4 <?=$report_mode === 'personal-report' ? 'active' : ''?>" href="pdf-report.php">Personal Report</a>
    </li>
    <li class="nav-item">
        <a class="nav-link p-4 <?=$report_mode === 'compatibility-report' ? 'active' : ''?>" href="pdf-report.php?report_mode=compatibility-report">Compatibility Report</a>
    </li>
</ul>

<?php if ($report_mode === 'personal-report'): ?>
<legend class="col-form-label text-center text-black py-4 text-xlarge">Persons Birth Details</legend>
<hr>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">First Name:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' name="first_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter first name" required>
    </div>
</div>


<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Middle Name:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' name="middle_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter middle name">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Last Name:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' name="last_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter last name" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Gender:</label>
    <div class="col-sm-9 col-md-6 ">
        <select name="gender" class="form-control form-control-lg rounded-1">
            <option value="male" >Male</option>
            <option value="female" >Female</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Chart:</label>
    <div class="col-sm-9 col-md-6 ">
        <select name="chart_type" class="form-control form-control-lg rounded-1">
            <option value="north-indian" >North Indian</option>
            <option value="south-indian" >South Indian</option>
            <option value="east-indian" >East Indian</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Show All Ashtakavarga:</label>
    <div class="col-sm-9 col-md-6 ">
        <select name="show_all_ashtakavarga" class="form-control form-control-lg rounded-1">
            <option value="1" >true</option>
            <option value="0" >false</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Chart:</label>
    <div class="col-sm-9 col-md-6 ">
        <select name="planet" class="form-control form-control-lg rounded-1">

            <?php foreach (Planet::PLANET_LIST as $planet_id => $planet): ?>

                <option value="<?=$planet_id?>" ><?=$planet?></option>

              <?php endforeach; ?>

        </select>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Date:<sup class="text-danger">*</sup></label>
    <div class="col-sm-9 col-md-6 ">
        <input type='datetime-local' disabled name="datetime" class="form-control form-control-lg rounded-1" required="required" value="1973-04-24 20:52"/>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Place of birth:<sup class="text-danger">*</sup></label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' id="fin-location" disabled name="location" class="form-control form-control-lg rounded-1" placeholder="Place of birth" value="New York, USA" required>
    </div>
</div>
<legend class="col-form-label text-center text-black py-4 text-xlarge">Report Details</legend>
<hr>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Report Name:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' name="report_name" class="form-control form-control-lg rounded-1" value="Custom Report Name" placeholder="Enter a custom report">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Report Caption:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' name="report_caption" class="form-control form-control-lg rounded-1" value="Custom Report Caption" placeholder="Enter a custom report">
    </div>
</div>


<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Choose Report:<sup class="text-danger">*</sup></label>
    <div class="col-sm-9 col-md-6 ">
        <div class="mb-5">
            <label>
                <input type='radio' name="report" value="mangal-dosha-report" checked> Mangal Dosha Report
            </label>
            <textarea rows="5" disabled class="form-control">
birth-details
chart
planet-position
mangal-dosha
        </textarea>
        </div>
        <div>
            <label>
                <input type='radio' name="report" value="personal-report">Personal Report
            </label>
            <textarea rows="10" disabled class="form-control">
birth-details
chart
planet-position
mangal-dosha
yoga-details
kaal-sarp-dosha
sade-sati
shodasavarga-chart
dasa-periods
planet-relationship
ashtagavarga
sarvashtagavarga
sudarshana-chakra
        </textarea>
        </div>
    </div>
</div>
<input type="hidden" name="report_mode" value="personal-report">
<?php else: ?>
    <legend class="col-form-label text-center text-black py-4 text-xlarge">Girl & Boy Birth Details</legend>
    <hr>
    <div class="row">
        <div class="col-12 col-md-6">
            <legend class="col-form-label text-black py-4 text-xlarge">Enter Girl's Birth Details</legend>
            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Girl First Name:</label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='text' name="girl_first_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter first name" required>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Girl Middle Name:</label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='text' name="girl_middle_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter middle name">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Girl Last Name:</label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='text' name="girl_last_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter last name" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 pr-md-0 col-form-label">Date Of Birth:<sup class="text-danger">*</sup></label>
                <div class="col-md-8 pl-md-0">
                    <input type='datetime-local' name="girl_dob" class="form-control form-control-lg rounded-1" disabled required="required" value="1975-11-10 01:55"/>
                </div>
            </div>
            <div id="glocationField" class="form-group row">
                <label class="col-md-4 pr-md-0 col-form-label">Place of birth:<sup class="text-danger">*</sup></label>
                <div class="col-md-8 pl-md-0">
                    <div id='g-location'>
                        <input type='text' id="fin-girl-location" name="girl_location" class="form-control form-control-lg rounded-1" placeholder="Place of birth" value="London, UK" required="required" disabled/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <legend class="col-form-label text-black py-4 text-xlarge">Enter Boy's Birth Details</legend>
            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Boy First Name:</label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='text' name="boy_first_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter first name" required>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Boy Middle Name:</label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='text' name="boy_middle_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter middle name">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Boy Last Name:</label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='text' name="boy_last_name" class="form-control form-control-lg rounded-1" value="" placeholder="Enter last name" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 pr-md-0 col-form-label">Date Of Birth:<sup class="text-danger">*</sup></label>
                <div class="col-md-8 pl-md-0">
                    <input type='datetime-local' name="boy_dob" class="form-control form-control-lg rounded-1"  required="required" value="1973-04-24 20:52" disabled/>
                </div>
            </div>
            <div id="blocationField" class="form-group row">
                <label class="col-md-4 pr-md-0 col-form-label">Place of birth:<sup class="text-danger">*</sup></label>
                <div class="col-md-8 pl-md-0">
                    <div id='b-location'>
                        <input type='text' id="fin-boy-location" name="boy_location" class="form-control form-control-lg rounded-1" placeholder="Place of birth" value="New York, USA" required="required" disabled/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <legend class="col-form-label text-center text-black py-4 text-xlarge">Report Details</legend>
    <hr>
    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Report Name:</label>
        <div class="col-sm-9 col-md-6 ">
            <input type='text' name="report_name" class="form-control form-control-lg rounded-1" value="Custom Report Name" placeholder="Enter a custom report">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Report Caption:</label>
        <div class="col-sm-9 col-md-6 ">
            <input type='text' name="report_caption" class="form-control form-control-lg rounded-1" value="Custom Report Caption" placeholder="Enter a custom report">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Choose Report:<sup class="text-danger">*</sup></label>
        <div class="col-sm-9 col-md-6 ">
            <div class="mb-3">
                <label>
                    <input type='radio' name="report" value="kundli-matching" checked> Kundli Matching
                </label>
                <textarea rows="4" disabled class="form-control">
birth-details
mangal-dosha
kundli-matching
                </textarea>
            </div>
            <div class="mb-3">
                <label>
                    <input type='radio' name="report" value="kerala-porutham"> Kerala Porutham
                </label>
                <textarea rows="4" disabled class="form-control">
birth-details
mangal-dosha
porutham-kerala
                </textarea>
            </div>
            <div>
                <label>
                    <input type='radio' name="report" value="tamil-porutham">Tamil Porutham
                </label>
                <textarea rows="4" disabled class="form-control">
birth-details
mangal-dosha
porutham-tamil
                </textarea>
            </div>
        </div>
    </div>
    <input type="hidden" name="report_mode" value="compatibility-report">
<?php endif; ?>
<legend class="col-form-label text-center text-black py-4 text-xlarge">Branding and Template Settings</legend>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Brand Name:<sup class="text-danger">*</sup></label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' disabled class="form-control form-control-lg rounded-1" value="Prokerala" placeholder="Enter a brand name">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Footer:<sup class="text-danger">*</sup></label>
    <div class="col-sm-9 col-md-6 ">
        <textarea rows="4" disabled class="form-control"><a href="https://www.prokerala.com">prokerala.com</a> | 📧 support@prokerala.com | Call Now: 1800 425 0053</textarea>
    </div>
</div>
