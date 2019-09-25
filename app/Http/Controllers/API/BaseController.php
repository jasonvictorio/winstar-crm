<?php

namespace WinstarCRM\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use WinstarCRM\Http\Controllers\Controller;
use \WinstarCRM\Company;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    protected $modelString;
    protected $model;
    protected $with = [];
    protected $hidden = [];
    protected $validationRules = [];
    protected $appendUserCompany = false;
    protected $appendUser = true;

    function __construct() {
        // create an instance of the model to be used
        $modelString = '\WinstarCRM\\'.$this->modelString;
        $this->model = new $modelString;

        // eg: with="[company]" hidden="[company_id]"
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
        // sort and pagination
        $sortBy = $request->header('sortBy') ?: 'id';
        $sortOrder = $request->header('sortOrder') ?: 'asc';
        $perPage = $request->header('perPage') ?: 15;

        // pagination with sort and relation($this->with)
        $result = $this->model::with($this->with)->orderBy($sortBy, $sortOrder)->paginate($perPage);
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
        return $this->validateRequest($request, function ($data) {
            return $this->model::create($data);
        });
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
        return $this->validateRequest($request, function ($data) use ($id) {
            $toBeUpdated = $this->model::findOrFail($id);
            $toBeUpdated->update($data);
            return $toBeUpdated;
        });
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

    // returns all entries
    // used in autocomplete
    public function all() {
        return $this->model::all();
    }

    // converts relation fields(array) to *_id
    // append company and user if applicable
    public function formatRequestModel ($request) {
        $model = [];
        foreach ($request->all() as $property => $value) {
            if (is_array($value)) {
                $model[$property.'_id'] = $value['id'];
            } else {
                $model[$property] = $value;
            }
        }

        // add company_id from user making the request
        if ($this->appendUserCompany) {
            $model['company_id'] = isset($model['company_id'])
                ? $model['company_id']
                : $request->user()->company_id;
        }

        // add user_id from user making the request
        if ($this->appendUser) {
            $model['user_id'] = isset($model['user_id'])
                ? $model['user_id']
                : $request->user()->id;

        }

        return $model;
    }

    public function getValidationError($data) {
        $validator = Validator::make($data, $this->validationRules);
        if ($validator->fails()) {
            return Response::make($validator->errors(), 422);
        }
    }

    //  accepts a function that runs when request is valid
    // function parameter must accept 'data' and return 'data'
    public function validateRequest($request, $callback) {
        $formatedRequestData = $this->formatRequestModel($request);
        $validationError = $this->getValidationError($formatedRequestData);
        if ($validationError) return $validationError;
        $data = $callback($formatedRequestData);
        return $this->model::with($this->with)->findOrFail($data->id);
    }
}
