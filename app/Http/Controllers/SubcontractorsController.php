<?php

namespace WinstarCRM\Http\Controllers;

use Illuminate\Http\Request;

// Models
use WinstarCRM\Subcontractors;

class SubcontractorsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('subcontractors');
    }
}
