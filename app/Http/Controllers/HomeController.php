<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with general CPNS information
     */
    public function index()
    {
        return view('home');
    }
}
