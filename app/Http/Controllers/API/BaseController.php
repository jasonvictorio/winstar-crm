<?php

namespace WinstarCRM\Http\Controllers\API;

use Illuminate\Http\Request;
use WinstarCRM\Http\Controllers\Controller;
use \WinstarCRM\Company;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    private $modelString = '';

    public function __construct($modelString) {
        $this->modelString = $modelString;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  DB::table($this->modelString)->paginate(15);
        // return  DB::table('companies')->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
