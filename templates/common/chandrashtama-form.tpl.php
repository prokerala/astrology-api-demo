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
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left ">Year:</label>
    <div class="col-sm-9 col-md-6 ">
        <input type='text' id="fin-year" name="year" autocomplete="off" class="form-control form-control-lg rounded-1" placeholder="Enter the years in int (eg: 2022)" value="2022" disabled>
        <span class="text-small text-muted">The default year is set to 2022 for the demo version.</span>
    </div>
</div>
<?php if (isset($arSupportedLanguages)): ?>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Language</label>
    <div class="col-sm-9 col-md-6">
        <select name="la" class="form-control form-control-lg rounded-1">
            <?php foreach ($arSupportedLanguages as $laValue => $laName): ?>
                <option value="<?=$laValue?>" ><?=$laName?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<?php endif; ?>
<div id="form-hidden-fields">

</div>
