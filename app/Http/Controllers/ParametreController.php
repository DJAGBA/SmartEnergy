<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParametreController extends Controller
{
    public function index()
    {
        return view('parametres.index');
    }
}