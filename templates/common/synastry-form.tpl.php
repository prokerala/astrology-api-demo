<div class="row">
    <div class="col-12 col-md-6">
        <legend class="col-form-label text-black py-4 text-xlarge">Enter Primary Birth Details</legend>
        <div class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Date Of Birth:</label>
            <div class="col-md-8 pl-md-0">
                <input type='datetime-local' name="girl_dob" class="form-control form-control-lg rounded-1"  required="required" value="<?= $primaryBirthTime->format('Y-m-d\TH:i')?>"/>
            </div>
        </div>
        <div id="glocationField" class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Place of birth:</label>
            <div class="col-md-8 pl-md-0">
                <div id='g-location'>
                    <input type='text' id="fin-girl-location" name="girl_location" autocomplete="off" class="porutham-form-input autocomplete form-control form-control-lg rounded-1 prokerala-location-input" data-location_input_prefix="girl_" placeholder="Place of birth" value="" required="required"/>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label ">Birth Time is Unknown: </label>
            <div class="col-sm-9 col-md-6 ">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="partner_a_birth_time_unknown" id="partner_a_birth_time_unknown1" value="false" <?='false' === $primaryBirthTimeUnknown ? 'checked' : ''?>>
                    <label class="form-check-label" for="partner_a_birth_time_unknown1">No</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="partner_a_birth_time_unknown" id="partner_a_birth_time_unknown2" value="true" <?='true' === $primaryBirthTimeUnknown ? 'checked' : ''?>>
                    <label class="form-check-label" for="partner_a_birth_time_unknown2">Yes</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <legend class="col-form-label text-black py-4 text-xlarge">Enter Secondary Birth Details</legend>
        <div class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Date Of Birth:</label>
            <div class="col-md-8 pl-md-0">
                <input type='datetime-local' name="boy_dob" class="form-control form-control-lg rounded-1"  required="required" value="<?= $secondaryBirthTime->format('Y-m-d\TH:i')?>"/>
            </div>
        </div>
        <div id="blocationField" class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Place of birth:</label>
            <div class="col-md-8 pl-md-0">
                <div id='b-location'>
                    <input type='text' id="fin-boy-location" name="boy_location" autocomplete="off" class="porutham-form-input autocomplete form-control form-control-lg rounded-1 prokerala-location-input" data-location_input_prefix="boy_" placeholder="Place of birth" value="" required="required"/>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label ">Birth Time is Unknown: </label>
            <div class="col-sm-9 col-md-6 ">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="partner_b_birth_time_unknown" id="partner_b_birth_time_unknown1" value="false" <?='false' === $secondaryBirthTimeUnknown ? 'checked' : ''?>>
                    <label class="form-check-label" for="partner_b_birth_time_unknown1">No</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="partner_b_birth_time_unknown" id="partner_b_birth_time_unknown2" value="true" <?='true' === $secondaryBirthTimeUnknown ? 'checked' : ''?>>
                    <label class="form-check-label" for="partner_b_birth_time_unknown2">Yes</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <?php if(in_array($sample_name, ['composite-chart', 'composite-aspect-chart'])) : ?>
        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label">Transit Date:</label>
            <div class="col-sm-9 col-md-6">
                <input type='date' name="transit_datetime" class="form-control form-control-lg rounded-1"  required="required" value="<?= $transitDateTime->format('Y-m-d')?>"/>
            </div>
        </div>
        <div id="blocationField" class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label">Reference Place:</label>
            <div class="col-sm-9 col-md-6">
                <div id='b-location'>
                    <input type='text' id="fin-current-location" name="current_location" autocomplete="off" class="porutham-form-input autocomplete form-control form-control-lg rounded-1 prokerala-location-input" data-location_input_prefix="boy_" placeholder="Reference Place" value="" required="required"/>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label">House System: </label>
        <div class="col-sm-9 col-md-6">
            <select name="house_system" class="form-control form-control-lg rounded-1">
                <option value="placidus" <?= 'placidus' === $houseSystem ? 'selected' : ''?>>Placidus</option>
                <option value="koch" <?= 'koch' === $houseSystem ? 'selected' : ''?>>Koch</option>
                <option value="whole-sign" <?= 'whole-sign' === $houseSystem ? 'selected' : ''?>>Whole Sign</option>
                <option value="equal-house" <?= 'equal-house' === $houseSystem ? 'selected' : ''?>>Equal House</option>
                <option value="m-house" <?= 'm-house' === $houseSystem ? 'selected' : ''?>>M House</option>
                <option value="porphyrius" <?= 'porphyrius' === $houseSystem ? 'selected' : ''?>>Porphyrius</option>
                <option value="regiomontanus" <?= 'regiomontanus' === $houseSystem ? 'selected' : ''?>>Regiomontanus</option>
                <option value="campanus" <?= 'campanus' === $houseSystem ? 'selected' : ''?>>Campanus</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label ">Orb: </label>
        <div class="col-sm-9 col-md-6 ">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="orb" id="orb1" value="default" <?='default' === $orb ? 'checked' : ''?>>
                <label class="form-check-label" for="orb1">Default</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="orb" id="orb2" value="exact" <?='exact' === $orb ? 'checked' : ''?>>
                <label class="form-check-label" for="orb2">Exact</label>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label ">Aspect Filter: </label>
        <div class="col-sm-9 col-md-6 ">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="aspect_filter" id="aspect_filter1" value="all" <?='all' === $aspectFilter ? 'checked' : ''?>>
                <label class="form-check-label" for="aspect_filter1">All</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="aspect_filter" id="aspect_filter2" value="major" <?='major' === $aspectFilter ? 'checked' : ''?>>
                <label class="form-check-label" for="aspect_filter2">Major</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="aspect_filter" id="aspect_filter3" value="minor" <?='minor' === $aspectFilter ? 'checked' : ''?>>
                <label class="form-check-label" for="aspect_filter3">Minor</label>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label ">Rectification Chart: </label>
        <div class="col-sm-9 col-md-6 ">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="rectification_chart" id="rectification_chart1" value="noon" <?='noon' === $rectificationChart ? 'checked' : ''?>>
                <label class="form-check-label" for="rectification_chart1">Flat Chart</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="rectification_chart" id="rectification_chart2" value="sunrise" <?='sunrise' === $rectificationChart ? 'checked' : ''?>>
                <label class="form-check-label" for="rectification_chart2">True Sunrise</label>
            </div>
        </div>
    </div>

</div>
