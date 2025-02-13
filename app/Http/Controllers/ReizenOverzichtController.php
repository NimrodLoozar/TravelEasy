<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReizenOverzichtController extends Controller
{
    public function index()
    {
        return view('ReisOverzicht.index');
    }
}
