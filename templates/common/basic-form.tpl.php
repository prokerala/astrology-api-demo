<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Ayanamsa</label>
    <div class="col-sm-9 col-md-6">
        <select name="ayanamsa" class="form-control form-control-lg rounded-1">
            <option value="1" <?=$ayanamsa == 1 ? 'selected' :''?>>Lahiri</option>
            <option value="3" <?=$ayanamsa == 3 ? 'selected' :''?>>Raman</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Date and Time:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type='datetime-local' name="datetime" class="form-control form-control-lg rounded-1" required="required" value="<?=$datetime->format('Y-m-d\Th:i')?>"/>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Place of birth:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' id="coordinates" name="coordinates" class="form-control form-control-lg rounded-1" placeholder="Place of birth" value="<?=$coordinates?>" required>
    </div>
</div>
