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
    protected $validationRules = [
        'name' => 'required',
        'company_id' => 'required',
    ];

    public function store(Request $request) {
        return $this->validateRequest($request, function ($data) {
            $model = $this->model::create([
                'company_id' => $data['company_id'],
                'access_id' => $data['access_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $model->sendEmailVerificationNotification();
            return $model;
        });
    }
}
