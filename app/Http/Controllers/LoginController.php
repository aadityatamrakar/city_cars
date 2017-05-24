<?php

namespace App\Http\Controllers;

use App\Session;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            "email"     =>  "required",
            "password"  =>  "required",
        ]);

        if(($user = User::where([['email', $request->email], ['password', $request->password]])->first()) != null){
            if($user->block == 1)
                return redirect()->route('login')
                    ->with(['info'=>"User Blocked! Contact Administrator.", 'type'=>"error"]);
            Auth::login($user);
            setcookie('email', $request->email);
            $dd = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);
            $dd->parse();
            $client = $dd->getClient()['type']." (".$dd->getClient()['name'].' - '.$dd->getClient()['version'].")";
            $operating_system = $dd->getOs()['name'].' '.$dd->getOs()['version'];
            // Store Session Details
            Session::create([ 'user_id'=>$user->id, 'ip_addr'=>$_SERVER['REMOTE_ADDR'], 'client'=>$client, 'operating_system'=>$operating_system, 'device'=>$dd->getDevice(), 'brand_name'=>$dd->getBrandName(), 'model'=>$dd->getModel()]);

            // if(Carbon::parse($user->password_changed)->diffInDays() > 90){
            //  $message = 'Password is more than 30 Days old, Kindly Change your password.';
            // }else $message = '';

            return redirect()->route('dashboard')
                ->with(['info'=>"Login Success!", 'type'=>"success"]);
        }else{
            return redirect()->route('login')
                ->with(['info'=>"Login Failed! Check credentials and Retry.", 'type'=>"error"]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
