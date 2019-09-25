<?php

namespace WinstarCRM\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use WinstarCRM\Http\Controllers\API\BaseController;

class UserController extends BaseController
{
    protected $modelString = 'User';
    protected $with = ['company', 'role'];
    protected $validationRules = [
        'name' => 'required',
        'company_id' => 'required',
        'email' => 'required|unique:users',
        'role_id' => 'required',
    ];

    public function store(Request $request) {
        return $this->validateRequest($request, function ($data) {
            $model = $this->model::create([
                'company_id' => $data['company_id'],
                'role_id' => $data['role_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $model->sendEmailVerificationNotification();
            return $model;
        });
    }
}
