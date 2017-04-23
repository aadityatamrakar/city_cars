<form class="form-horizontal" id="transaction_form" onsubmit="return false;">
    <fieldset>
        {!! csrf_field() !!}
        <input type="hidden" id="customer_id" name="customer_id" />
        <input type="hidden" id="transaction_id" name="transaction_id" />
        <div class="form-group">
            <label class="col-md-4 control-label" for="transaction_date">Transaction Date</label>
            <div class="col-md-5">
                <input id="transaction_date" autocomplete="off" name="transaction_date" type="text" value="{{ date('d/m/Y') }}" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="vehicle_id">Vehicle</label>
            <div class="col-md-5">
                <select id="vehicle_id" name="vehicle_id" class="form-control"></select>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="transaction_type">Transaction Type</label>
            <div class="col-md-5">
                <select id="transaction_type" name="transaction_type" class="form-control">
                    @foreach(json_decode(file_get_contents(storage_path('app/transaction_types.json'))) as $type)
                        <option value="{{ strtoupper($type) }}">{{ strtoupper($type) }}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="amount">Amount</label>
            <div class="col-md-5">
                <input id="amount" name="amount" type="text" placeholder="" class="form-control input-md" required="">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="mobile">Mobile</label>
            <div class="col-md-5">
                <input id="mobile" name="mobile" type="text" placeholder="" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="rating">Rating</label>
            <div class="col-md-5">
                <input id="rating" name="rating" type="text" placeholder="" class="form-control input-md">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="remark">Remark</label>
            <div class="col-md-4">
                <textarea class="form-control" id="remark" name="remark"></textarea>
                <span class="help-block"></span>
            </div>
        </div>
    </fieldset>
</form>