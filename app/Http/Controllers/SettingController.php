<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        if(! UsersController::check_access(4))
            return redirect()->route('access_denied')->with(['type'=>"error", 'info'=>"Access Denied!"]);
        return view('settings.index');
    }

    public function test()
    {
        file_put_contents(storage_path('app/vehicles.json'), '["test", "1", "2"]');
        dd(json_decode(file_get_contents(storage_path('app/vehicles.json'))));
    }

    public function save_setting( Request $request)
    {
        $vehicle_models = json_encode(explode(',', $request->vehicle_models));
        $transaction_types = json_encode(explode(',', $request->transaction_types));
        file_put_contents(storage_path('app/vehicle_models.json'), $vehicle_models);
        file_put_contents(storage_path('app/transaction_types.json'), $transaction_types);
        return redirect()->route('settings.index')
            ->with(["type"=>"success", 'info'=>"Settings Updated!"]);
    }
}
