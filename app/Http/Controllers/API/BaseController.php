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
    protected $hidden = [];
    protected $appendUserCompany = false;

    function __construct() {
        $modelString = '\WinstarCRM\\'.$this->modelString;
        $this->model = new $modelString;
        $this->hidden = $this->mapWithAsHiddenId();
    }

    function mapWithAsHiddenId() {
        $appendIdtoString = function($string) {
            return $string.'_id';
        };
        return array_map($appendIdtoString, $this->with);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = $request->header('sortBy') ?: 'id';
        $sortOrder = $request->header('sortOrder') ?: 'asc';
        $result = $this->model::with($this->with)->orderBy($sortBy, $sortOrder)->paginate(15);
        $data = $result->makeHidden($this->hidden);
        $result->data = $data;
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->model::create($this->formatRequestModel($request));
        return $model;
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
        $model->update($this->formatRequestModel($request));
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

    public function formatRequestModel ($request) {
        $model = [];
        foreach ($request->all() as $property => $value) {
            if (is_array($value)) {
                $model[$property.'_id'] = $value['id'];
            } else {
                $model[$property] = $value;
            }
        }
        if ($this->appendUserCompany) {
            $model['company_id'] = isset($model['company_id']) ? $model['company_id'] : $request->user()->company_id;
        }
        return $model;
    }
}
