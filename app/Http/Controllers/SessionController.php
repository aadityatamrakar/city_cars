<?php

namespace App\Http\Controllers;

use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class SessionController extends Controller
{
    public function index()
    {
        if(! UsersController::check_access(3))
            return redirect()->route('access_denied')->with(['type'=>"error", 'info'=>"Access Denied!"]);
        return view('session.index');
    }

    public function datatables_ajax_sessions()
    {
        //$sessions = Session::first()->with('user');
        $sessions = DB::table('sessions')->join('users', 'sessions.user_id', '=', 'users.id')
            ->select([
                'sessions.id as sid',
                'users.id as uid',
                'users.name', 'users.mobile', 'users.email',
                'ip_addr', 'sessions.created_at as created_at',
                'client', 'operating_system', 'device',
                'brand_name', 'model', 'sessions.id'])
            ->orderBy('sessions.id', 'desc');

        return Datatables::of($sessions)
            ->make(true);
    }
}
