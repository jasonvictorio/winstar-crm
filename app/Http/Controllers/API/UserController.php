<?php

namespace WinstarCRM\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use WinstarCRM\Http\Controllers\API\BaseController;

class UserController extends BaseController
{
    protected $modelString = 'User';
    protected $with = ['company', 'access'];

    public function store(Request $request) {
        $requestModel = $this->formatRequestModel($request);
        $model = $this->model::create([
            'company_id' => $requestModel['company_id'],
            'access_id' => $requestModel['access_id'],
            'name' => $requestModel['name'],
            'email' => $requestModel['email'],
            'password' => Hash::make(Str::random(10)),
        ]);
        $model->sendEmailVerificationNotification();
        return $model;
    }
}
