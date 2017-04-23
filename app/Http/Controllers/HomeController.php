<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('home');
    }

    public function blank()
    {
        return view('blank');
    }

    public function access_denied()
    {
        return view('access_denied');
    }
}
