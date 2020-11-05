<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Ayanamsa</label>
    <div class="col-sm-9 col-md-6">
        <select name="ayanamsa" class="form-control form-control-lg rounded-1">
            <option value="1" <?=1 == $ayanamsa ? 'selected' : ''?>>Lahiri</option>
            <option value="3" <?=3 == $ayanamsa ? 'selected' : ''?>>Raman</option>
            <option value="5" <?=5 == $ayanamsa ? 'selected' : ''?>>KP</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Date: </label>
    <div class="col-sm-9 col-md-6 ">
        <input type='date' name="datetime" class="form-control form-control-lg rounded-1" required="required" value="<?=$datetime->format('Y-m-d')?>"/>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Location:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type="text" name="location" autocomplete="off" class="form-control form-control-lg rounded-1 prokerala-location-input" placeholder="Enter Location" value="" required>
    </div>
</div>

<div id="form-hidden-fields">

</div>