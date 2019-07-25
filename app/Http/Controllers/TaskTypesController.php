<?php

namespace WinstarCRM\Http\Controllers;

use Illuminate\Http\Request;

// Models
use WinstarCRM\TaskType;

class TaskTypesController extends Controller
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
        return view('task_types');
    }
}
