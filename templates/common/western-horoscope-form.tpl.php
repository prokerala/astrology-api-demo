<div class="row">

    <div class="col-12 col-md-6">

        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Date: </label>
            <div class="col-sm-9 col-md-6 ">
                <input type='datetime-local' name="datetime" class="form-control form-control-lg rounded-1" required="required" value="<?= $datetime->format('Y-m-d\TH:i')?>"/>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Place of birth:</label>
            <div class="col-sm-9 col-md-6 ">
                <input type='text' id="fin-location" name="location" autocomplete="off" class="form-control form-control-lg rounded-1 prokerala-location-input" placeholder="Place of birth" value="" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">House System: </label>
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
        <?php if (in_array($sample_name, ['transit-chart', 'transit-aspect-chart'])): ?>
            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Transit Date Time: </label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='datetime-local' name="transit_datetime" class="form-control form-control-lg rounded-1" required="required" value="<?= $transitDatetime->format('Y-m-d\TH:i')?>"/>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Transit Location:</label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='text' id="fin-current-location" name="current_location" autocomplete="off" class="form-control form-control-lg rounded-1 prokerala-location-input" placeholder="Transit Location" value="" required>
                </div>
            </div>
        <?php elseif (in_array($sample_name, ['progression-chart', 'progression-aspect-chart'])): ?>
            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Progression Year: </label>
                <div class="col-sm-9 col-md-6 ">
                    <input type="number" name="progression_year" class="form-control form-control-lg rounded-1" placeholder="Enter Progression Year" value="<?= $progressionYear?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Progressed Location:</label>
                <div class="col-sm-9 col-md-6 ">
                    <input type='text' id="fin-current-location" name="current_location" autocomplete="off" class="form-control form-control-lg rounded-1 prokerala-location-input" placeholder="Progressed Location" value="" required>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-12 col-md-6">

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
                    <input class="form-check-input" type="radio" name="aspect_filter" id="aspect_filter2" value="minor" <?='minor' === $aspectFilter ? 'checked' : ''?>>
                    <label class="form-check-label" for="aspect_filter2">Minor</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label ">Birth Time Known: </label>
            <div class="col-sm-9 col-md-6 ">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="birth_time_unknown" id="birth_time_unknown1" value="false" <?='false' === $birthTimeUnknown ? 'checked' : ''?>>
                    <label class="form-check-label" for="birth_time_unknown1">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="birth_time_unknown" id="birth_time_unknown2" value="true" <?='true' === $birthTimeUnknown ? 'checked' : ''?>>
                    <label class="form-check-label" for="birth_time_unknown2">No</label>
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
</div>
