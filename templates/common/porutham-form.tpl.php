<div class="row">
    <div class="col-12 col-md-6">
        <legend class="col-form-label text-black py-4 text-xlarge">Enter Girl's Birth Details</legend>
        <div class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Date Of Birth:</label>
            <div class="col-md-8 pl-md-0">
                <input type='datetime-local' name="girl_dob" class="form-control form-control-lg rounded-1"  required="required" value="<?=$girl_dob->format('Y-m-d\TH:i')?>"/>
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
    </div>
    <div class="col-12 col-md-6">
        <legend class="col-form-label text-black py-4 text-xlarge">Enter Boy's Birth Details</legend>
        <div class="form-group row">
            <label class="col-md-4 pr-md-0 col-form-label">Date Of Birth:</label>
            <div class="col-md-8 pl-md-0">
                <input type='datetime-local' name="boy_dob" class="form-control form-control-lg rounded-1"  required="required" value="<?=$boy_dob->format('Y-m-d\TH:i')?>"/>
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
    </div>
</div>

<div id="form-hidden-fields">

</div>