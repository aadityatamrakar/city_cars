<?php

namespace App\Http\Controllers;

use App\Mailing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MailingController extends Controller
{
    public function index()
    {
        return view('mailing.index');
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"        =>  "required",
            "cron_job"      =>  "required",
            "report"        =>  "required",
            "users"         =>  "required",
        ]);

        if ($validator->fails()) {
            $data = ['status'=>"validation_failed"];
            $data['validator'] = $validator->errors();
            return $data;
        }else{
            $data = $request->only('title', 'cron_job');
            $data['report_id'] = $request->report;
            $data['users'] = json_encode($request->users);
            $data['user_id'] = Auth::user()->id;
            if($request->has('mailing_id') && ($mailing=Mailing::find($request->mailing_id))!=null && $mailing->update($data))
                return ['status'=>"updated"];
            else{
                $mailing = Mailing::create($data);
                return ['status'=>"success", 'mailing'=>$mailing];
            }
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id"         =>  "required",
        ]);

        if ($validator->fails()) {
            $data = ['status'=>"validation_failed"];
            $data['validator'] = $validator->errors();
            return $data;
        }else{
            if(Mailing::find($request->id)->delete())
                return ['status'=>"deleted"];
            else return ['status'=>'error'];
        }
    }
}
