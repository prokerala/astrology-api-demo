<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Ayanamsa</label>
    <div class="col-sm-9 col-md-6">
        <select name="ayanamsa" class="form-control form-control-lg rounded-1">
            <option value="1" <?= 1 === $ayanamsa ? 'selected' : ''?>>Lahiri</option>
            <option value="3" <?= 3 === $ayanamsa ? 'selected' : ''?>>Raman</option>
            <option value="5" <?= 5 === $ayanamsa ? 'selected' : ''?>>KP</option>
        </select>
    </div>
</div>
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
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Language</label>
    <div class="col-sm-9 col-md-6">
        <select name="la" class="form-control form-control-lg rounded-1">
            <option value="en" >English</option>
            <option value="ta" >Tamil</option>
            <option value="ml" >Malayalam</option>
            <option value="hi" >Hindi</option>
            <option value="te" >Telugu</option>
        </select>
    </div>
</div>

<div id="form-hidden-fields">

</div>
