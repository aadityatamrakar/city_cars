<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class UsersController extends Controller
{
    public static function check_access($access)
    {
        if(Auth::user()->role >= $access)
            return true;
        else
            return false;
    }

    public function index()
    {
        if(! UsersController::check_access(4))
            return redirect()->route('access_denied')->with(['type'=>"error", 'info'=>"Access Denied!"]);
        return view('users.index');
    }

    public function save_form(Request $request)
    {
        if($request->has('user_id'))
        {
            $validator = Validator::make($request->all(), [
                "name"      =>  "required",
                "mobile"    =>  "required|numeric|digits:10",
                "email"     =>  "email",
                "role"      =>  "numeric|between:1,4",
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                "name"      =>  "required",
                "mobile"    =>  "required|numeric|digits:10",
                "email"     =>  "email|unique:users",
                "password"  =>  "required",
                "role"      =>  "numeric|between:1,4",
            ]);
        }

        if ($validator->fails()) {
            $data = ['status'=>"validation_failed"];
            $data['validator'] = $validator->errors();
            return $data;
        }else{
            $data = $request->only('name', 'mobile', 'email', 'password', 'role', 'block');
            if($request->has('user_id')){
                if($data['password'] == '') unset($data['password']);
                $user = User::find($request->user_id);
                $user->update($data);
                return ['status'=>"updated", 'user_id'=>$user->id];
            }else {
                $user = User::create($data);
                return ['status' => "added", 'user_id' => $user->id];
            }
        }
    }

    public function user_delete(Request $request)
    {
        if(UsersController::check_access(4)) return [];
        User::find($request->user_id)->delete();
        return ["status"=>'ok'];
    }

    public function datatables_ajax_users()
    {
        $users = User::query();
        return Datatables::of($users)
            ->editColumn('password_changed', '{!! date(\'d/m/Y\', strtotime($password_changed)) !!}')
            ->make(true);
    }
}
