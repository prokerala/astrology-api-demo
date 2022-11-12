<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Date: </label>
    <div class="col-sm-9 col-md-6 ">
        <input type='date' name="date" class="form-control form-control-lg rounded-1" required="required" value="<?= $date->format('Y-m-d')?>"/>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Calendar</label>
    <div class="col-sm-9 col-md-6">
        <select name="calendar" class="form-control form-control-lg rounded-1" id="fin-select-calendar">
            <option value="tamil" >Tamil</option>
            <option value="shaka-samvat" >Shaka Samvat</option>
            <option value="vikram-samvat" >Vikram Samvat</option>
            <option value="amanta" >Amanta</option>
            <option value="purnimanta" >Purnimanta</option>
            <option value="malayalam" >Malayalam</option>
            <option value="hijri" >Hijri</option>
            <option value="gujarati" >Gujarati</option>
            <option value="bengali" >Bengali</option>
            <option value="lunar" >Lunar</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-md-4 col-form-label  text-md-right text-xs-left">Language</label>
    <div class="col-sm-9 col-md-6">
        <select name="la" class="form-control form-control-lg rounded-1" id="fin-supported-languages">
            <?php foreach ($supportedLanguages as $la_value => $la_name): ?>
                <option value="<?=$la_value?>" ><?=$la_name?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div id="form-hidden-fields">

</div>
