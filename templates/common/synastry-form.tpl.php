<div class="row">
    <div class="col-12 col-md-6">
        <legend class="col-form-label text-black py-4 text-xlarge">Enter Primary Profile</legend>
        <div class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Date Of Birth:</label>
            <div class="col-md-8 pl-md-0">
                <input type='datetime-local' name="partner_a_dob" class="form-control form-control-lg rounded-1"  required="required" value="<?= $primaryBirthTime->format('Y-m-d\TH:i')?>"/>
            </div>
        </div>
        <div class="form-group row text-small">
            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left"></label>
            <div class="col-md-8 pl-md-0">
                <div class="form-check form-check-inline">
                    <input class="form-check-input birth_time_unknown" type="checkbox" name="partner_a_birth_time_unknown" id="partner_a_birth_time_unknown" <?=isset($primaryBirthTimeUnknown) && $primaryBirthTimeUnknown ? 'checked' : ''?>>
                    <label class="form-check-label" for="partner_a_birth_time_unknown">Exact primary birth time is unknown</label>
                </div>
            </div>
        </div>
        <div id="alocationField" class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Place of birth:</label>
            <div class="col-md-8 pl-md-0">
                <div id='a-location'>
                    <input type='text' id="fin-partner-a-location" name="partner_a_location" autocomplete="off" class="porutham-form-input autocomplete form-control form-control-lg rounded-1 prokerala-location-input" data-location_input_prefix="partner_a_" placeholder="Place of birth" value="" required="required"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <legend class="col-form-label text-black py-4 text-xlarge">Enter Secondary Profile</legend>
        <div class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Date Of Birth:</label>
            <div class="col-md-8 pl-md-0">
                <input type='datetime-local' name="partner_b_dob" class="form-control form-control-lg rounded-1"  required="required" value="<?= $secondaryBirthTime->format('Y-m-d\TH:i')?>"/>
            </div>
        </div>
        <div class="form-group row text-small">
            <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left"></label>
            <div class="col-md-8 pl-md-0">
                <div class="form-check form-check-inline">
                    <input class="form-check-input birth_time_unknown" type="checkbox" name="partner_b_birth_time_unknown" id="partner_b_birth_time_unknown" <?=isset($secondaryBirthTimeUnknown) && $secondaryBirthTimeUnknown ? 'checked' : ''?>>
                    <label class="form-check-label" for="partner_b_birth_time_unknown">Exact secondary birth time is unknown</label>
                </div>
            </div>
        </div>
        <div id="primaryLocationField" class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Place of birth:</label>
            <div class="col-md-8 pl-md-0">
                <div id='b-location'>
                    <input type='text' id="fin-partner-b-location" name="partner_b_location" autocomplete="off" class="porutham-form-input autocomplete form-control form-control-lg rounded-1 prokerala-location-input" data-location_input_prefix="partner_b_" placeholder="Place of birth" value="" required="required"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <?php if(in_array($sample_name, ['composite-chart', 'composite-aspect-chart', 'composite-planet-aspect'])) : ?>
        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label text-md-right text-xs-left">Transit Date:</label>
            <div class="col-sm-9 col-md-6">
                <input type='date' name="transit_datetime" class="form-control form-control-lg rounded-1"  required="required" value="<?= $transitDateTime->format('Y-m-d')?>"/>
            </div>
        </div>
        <div id="secondaryLocationField" class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label text-md-right text-xs-left">Reference Place:</label>
            <div class="col-sm-9 col-md-6">
                <div id='b-location'>
                    <input type='text' id="fin-current-location" name="current_location" autocomplete="off" class="porutham-form-input autocomplete form-control form-control-lg rounded-1 prokerala-location-input" data-location_input_prefix="current_" placeholder="Reference Place" value="" required="required"/>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(in_array($sample_name, ['synastry-chart', 'synastry-aspect-chart', 'synastry-planet-aspect'])) : ?>
        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label text-md-right text-xs-left">Synastry Chart Type: </label>
            <div class="col-sm-9 col-md-6">
                <select name="chart_type" class="form-control form-control-lg rounded-1">
                    <option value="zodiac-contact-chart" <?= 'zodiac-contact-chart' === $houseSystem ? 'selected' : ''?>>Zodiacal Contact Chart</option>
                    <option value="house-contact-chart" <?= 'house-contact-chart' === $houseSystem ? 'selected' : ''?>>House Contact Chart</option>
                </select>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label text-md-right text-xs-left">House System: </label>
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
    <?php if(in_array($sample_name, ['synastry-chart', 'synastry-aspect-chart', 'composite-chart', 'composite-aspect-chart'])): ?>
        <div class="form-group row">
            <label class="col-sm-3 col-md-4 col-form-label text-md-right text-xs-left">Aspect Filter: </label>
            <div class="col-sm-9 col-md-6">
                <select name="aspect_filter" class="form-control form-control-lg rounded-1">
                    <option value="major" <?= 'major' === $aspectFilter ? 'selected' : ''?>>Show major aspects</option>
                    <option value="all" <?= 'all' === $aspectFilter ? 'selected' : ''?>>Show all aspects</option>
                    <option value="minor" <?= 'minor' === $aspectFilter ? 'selected' : ''?>>Show minor aspects only</option>
                </select>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group row">
        <label class="col-sm-3 col-md-4 col-form-label text-md-right text-xs-left">Orb: </label>
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
    <div class="form-group row d-none" id="birth_time_rectification_tab">
        <label class="col-sm-3 col-md-4 col-form-label text-md-right text-xs-left">Birth Time Rectification Chart: </label>
        <div class="col-sm-9 col-md-6 ">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="birth_time_rectification" id="rectification_chart1" value="flat-chart" <?='flat-chart' === $rectificationChart ? 'checked' : ''?>>
                <label class="form-check-label" for="rectification_chart1">Flat Chart</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="birth_time_rectification" id="rectification_chart2" value="true-sunrise-chart" <?='true-sunrise-chart' === $rectificationChart ? 'checked' : ''?>>
                <label class="form-check-label" for="rectification_chart2">True Sunrise Chart</label>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const birthTimeUnknownCheckboxes = document.querySelectorAll('.birth_time_unknown');
        const birthTimeRectificationTab = document.getElementById('birth_time_rectification_tab');

        birthTimeUnknownCheckboxes.forEach(function (el) {
            el.addEventListener('click', (e) => {
                const $primaryCheckbox = document.getElementById('partner_a_birth_time_unknown');
                const $secondaryCheckbox = document.getElementById('partner_b_birth_time_unknown');
                if($primaryCheckbox.checked || $secondaryCheckbox.checked){
                    birthTimeRectificationTab.classList.remove('d-none');
                } else {
                    if(!birthTimeRectificationTab.classList.contains('d-none')){
                        birthTimeRectificationTab.classList.add('d-none');
                    }
                }
            });
        });
    }());
</script>
