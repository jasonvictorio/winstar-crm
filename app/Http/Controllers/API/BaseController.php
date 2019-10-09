<?php

namespace WinstarCRM\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use WinstarCRM\Http\Controllers\Controller;
use \WinstarCRM\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    protected $modelString;
    protected $model;
    protected $with = [];
    protected $hidden = [];
    protected $files = [];
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
        $user = $request->user()->id;
        $userRole = 1;
        $userCompany = $request->user()->company_id;
        // sort and pagination
        $sortBy = $request->header('sortBy') ?: 'id';
        $sortOrder = $request->header('sortOrder') ?: 'asc';
        $perPage = $request->header('perPage') ?: 15;

        /*
            1,superadmin can view all
            2,admin can view from his own company
            3,staff can view from his own company
            4,
        */
        if ($userRole == 1) {
            $result = $this->model::where([]);
        } elseif ($userRole == 2) {
            $result = $this->model::where('company_id', $userCompany);
        } elseif ($userRole == 3) {
            $result = $this->model::where('company_id', $userCompany);
        } elseif ($userRole == 4) {
            $result = $this->model::where('user_id', $user);
        }
        // pagination with sort and relation($this->with)
        $result = $result->with($this->with)->orderBy($sortBy, $sortOrder)->paginate($perPage);
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

    public function report (Request $request) {
        $from = $request->header('from');
        $to = $request->header('to');
        $xxx = $this->model::with($this->with);

        if (!empty($from) || !empty($to)) {
            if (!empty($to)) {
                $xxx = $xxx->whereBetween('created_at', [$from, $to]);
            } else {
                $xxx = $xxx->where('created_at', '<=',$from);
            }
        }

        return $xxx->get()->makeHidden($this->hidden);
    }

    // converts relation fields(array) to *_id
    // append company and user if applicable
    public function formatRequestModel ($request) {
        $model = [];
        foreach ($request->all() as $property => $value) {
            if (is_array($value)) {
                $model[$property.'_id'] = $value['id'];
            } elseif (in_array($property, $this->files)) {
                 if ($value[-1] == "=") {
                    $image = $value; // image base64 encoded
                    preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
                    $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
                    $image = str_replace(' ', '+', $image);
                    $imageName = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;
                    \File::put(storage_path(). '/app/public/uploads/'.strtolower($this->modelString).'/'. $imageName, base64_decode($image));
                    $model[$property] = $imageName;
                 } else {
                    $model[$property] = $value;
                 }
            } elseif ($property == 'password') {
                $model[$property] = Hash::make($value);
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
