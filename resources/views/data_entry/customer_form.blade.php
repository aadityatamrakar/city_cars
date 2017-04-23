<form class="form-horizontal" onsubmit="return false;" id="customer_form">
    <fieldset>
        {!! csrf_field() !!}
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Customer Name</label>
            <div class="col-md-6">
                <input id="name" name="name" type="text" value="{{ $customer->name }}" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="mobile1">Mobile No.</label>
            <div class="col-md-3">
                <input id="mobile1" name="mobile1" data-toggle="check_duplicate" data-table="customers" type="text" value="{{ $customer->mobile1 }}" placeholder="Mobile 1" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
            <div class="col-md-3">
                <input id="mobile2" name="mobile2" data-toggle="check_duplicate" data-table="customers" type="text" value="{{ $customer->mobile2 }}" placeholder="Mobile 2" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="email">Email</label>
            <div class="col-md-6">
                <input id="email" name="email" type="text" data-toggle="check_duplicate" data-table="customers" value="{{ $customer->email }}" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="dob">Date of Birth</label>
            <div class="col-md-6">
                <input id="dob" name="dob" type="text" autocomplete="off" value="{{ $customer->dob!=''?$customer->dob->format('d/m/Y'):'' }}" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="city">City</label>
            <div class="col-md-6">
                <input id="city" name="city" type="text" value="{{ $customer->city }}" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="pincode">Pincode</label>
            <div class="col-md-6">
                <input id="pincode" name="pincode" type="text" value="{{ $customer->pincode }}" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="address">Address</label>
            <div class="col-md-4">
                <textarea class="form-control" id="address" name="address">{{ $customer->address }}</textarea>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="autocard">Autocard</label>
            <div class="col-md-4">
                <label class="radio-inline" for="autocard-0">
                    <input type="radio" name="autocard" id="autocard-0" value="No" {!! $customer->autocard=='No'||$customer->autocard==''?'checked="checked"':'' !!}>
                    No
                </label>
                <label class="radio-inline" for="autocard-1">
                    <input type="radio" name="autocard" id="autocard-1" value="Yes" {!! $customer->autocard=='Yes'?'checked="checked"':'' !!}>
                    Yes
                </label>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="save"></label>
            <div class="col-md-4">
                <button id="save" name="save" class="btn btn-primary">Save</button>
            </div>
        </div>
    </fieldset>
</form>