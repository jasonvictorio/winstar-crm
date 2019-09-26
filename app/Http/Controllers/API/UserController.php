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
    protected $files = ['avatar'];
    protected $validationRules = [
        'name' => 'required',
        'company_id' => 'required',
        'email' => 'required',
        'role_id' => 'required',
    ];

}
