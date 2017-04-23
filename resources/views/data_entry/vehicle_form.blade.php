<form class="form-horizontal" id="vehicle_form" onsubmit="return false;">
    <fieldset>
        {!! csrf_field() !!}
        <input type="hidden" id="customer_id" name="customer_id" />
        <input type="hidden" id="vehicle_id" name="vehicle_id" />
        <div class="form-group">
            <label class="col-md-4 control-label" for="reg_no">Reg. No.</label>
            <div class="col-md-5">
                <input id="reg_no" name="reg_no" data-toggle="check_duplicate" data-table="vehicles" type="text" placeholder="" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="chassis_no">Chassis No.</label>
            <div class="col-md-5">
                <input id="chassis_no" name="chassis_no" data-toggle="check_duplicate" data-table="vehicles" type="text" placeholder="" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="engine_no">Engine No</label>
            <div class="col-md-5">
                <input id="engine_no" name="engine_no" data-toggle="check_duplicate" data-table="vehicles" type="text" placeholder="" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="model">Model</label>
            <div class="col-md-5">
                <select id="model" name="model" class="form-control">
                    <option>--select--</option>
                    @foreach(json_decode(file_get_contents(storage_path('app/vehicle_models.json'))) as $model)
                        <option value="{{ strtoupper($model) }}">{{ strtoupper($model) }}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="variant">Variant</label>
            <div class="col-md-5">
                <input id="variant" name="variant" type="text" placeholder="" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="mfgyear">Mfg Year</label>
            <div class="col-md-5">
                <input id="mfgyear" name="mfgyear" type="text" placeholder="" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="mi">MI</label>
            <div class="col-md-4">
                <label class="radio-inline" for="mi-0">
                    <input type="radio" name="mi" id="mi-0" value="No" checked="checked">
                    No
                </label>
                <label class="radio-inline" for="mi-1">
                    <input type="radio" name="mi" id="mi-1" value="Yes">
                    Yes
                </label>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="finance">Finance</label>
            <div class="col-md-4">
                <label class="radio-inline" for="finance-0">
                    <input type="radio" name="finance" id="finance-0" value="No" checked="checked">
                    No
                </label>
                <label class="radio-inline" for="finance-1">
                    <input type="radio" name="finance" id="finance-1" value="Yes">
                    Yes
                </label>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="fuel">Fuel Type</label>
            <div class="col-md-8">
                <label class="radio-inline" for="fuel-0">
                    <input type="radio" name="fuel" id="fuel-0" value="Petrol" checked="checked">
                    Petrol
                </label>
                <label class="radio-inline" for="fuel-1">
                    <input type="radio" name="fuel" id="fuel-1" value="Diesel">
                    Diesel
                </label>
                <label class="radio-inline" for="fuel-2">
                    <input type="radio" name="fuel" id="fuel-2" value="Other">
                    Other
                </label>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="insurance">Insurance</label>
            <div class="col-md-5">
                <input id="insurance" name="insurance" autocomplete="off" type="text" placeholder="" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="warranty">Warranty</label>
            <div class="col-md-5">
                <input id="warranty" name="warranty" type="text" placeholder="" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="warranty_exp">Warranty Exp</label>
            <div class="col-md-5">
                <input id="warranty_exp" name="warranty_exp" autocomplete="off" type="text" placeholder="" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="amc">AMC</label>
            <div class="col-md-5">
                <input id="amc" name="amc" type="text" placeholder="" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="amc_exp">AMC Exp</label>
            <div class="col-md-5">
                <input id="amc_exp" name="amc_exp" autocomplete="off" type="text" placeholder="" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
    </fieldset>
</form>