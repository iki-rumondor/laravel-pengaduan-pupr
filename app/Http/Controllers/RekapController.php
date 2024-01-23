<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->view('rekap-pengaduan');
    }

}