<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $msg = 'hello';
        return view('home')->with('msg', $msg);
    }
}
