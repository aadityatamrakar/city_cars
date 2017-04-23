<form id="mailing_form" onsubmit="return false;" class="form-horizontal">
    <fieldset>
        {!! csrf_field() !!}
        <input type="hidden" value="" name="mailing_id" id="mailing_id" />

        <div class="form-group">
            <label class="col-md-3 control-label" for="name">Name</label>
            <div class="col-md-4">
                <input id="title" name="title" type="text" placeholder="" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-3 control-label" for="report">Report</label>
            <div class="col-md-5">
                <select style="width: 100%;" id="report" name="report" class="form-control">
                    <option value="">--select--</option>
                    @foreach(\App\Report::all() as $report)
                        <option value="{{ $report->id }}">{{ $report->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="cron_job">Run</label>
            <div class="col-md-9">
                <input id="cron_job" name="cron_job" type="hidden" class="form-control input-md" required="">
                <div style="padding-top: 7px;" id="cronjob"></div>
            </div>
        </div>

        <!-- Select Multiple -->
        <div class="form-group">
            <label class="col-md-3 control-label" for="users">Users</label>
            <div class="col-md-9">
                <select style="width: 100%;" id="users" name="users[]" class="form-control myselect2" multiple="multiple">
                    @foreach(\App\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-3 control-label" for="save"></label>
            <div class="col-md-4">
                <button id="save" name="save" class="btn btn-primary">Save</button>
            </div>
        </div>
    </fieldset>
</form>