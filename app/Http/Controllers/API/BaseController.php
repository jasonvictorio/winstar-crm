<?php

namespace WinstarCRM\Http\Controllers\API;

use Illuminate\Http\Request;
use WinstarCRM\Http\Controllers\Controller;
use \WinstarCRM\Company;
use Illuminate\Support\Facades\DB;
use Log;

class BaseController extends Controller
{
    protected $modelString;
    protected $model;
    protected $with = [];

    function __construct() {
        $modelString = '\WinstarCRM\\'.$this->modelString;
        $this->model = new $modelString;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model::with($this->with)->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $xx = $this->model::create($this->formatRequestModel($request->all()));
        return $xx;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->model::find($id);
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
        $model = $this->model::findOrFail($id);
        $model->update($this->formatRequestModel($request->all()));
        return $this->model::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->model::findOrFail($id);
        $model->delete();
        return $model;
    }

    public function all() {
        return $this->model::all();
    }

    public function formatRequestModel ($requestModel) {
        $updatedModel = [];
        foreach ($requestModel as $property => $value) {
            if (is_array($value)) {
                $updatedModel[$property.'_id'] = $value['id'];
            } else {
                $updatedModel[$property] = $value;
            }
        }
        return $updatedModel;
    }
}
