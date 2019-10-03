<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class CustomerController extends BaseController
{
    protected $modelString = 'Customer';
    protected $with = ['company', 'status'];
    protected $validationRules = [
        'first_name' => 'required',
        'company_id' => 'required',
        'status_id' => 'required',
    ];
}
