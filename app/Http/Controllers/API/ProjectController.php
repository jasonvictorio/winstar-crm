<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class ProjectController extends BaseController
{
    protected $modelString = 'Project';
    protected $with = ['company', 'status', 'customer'];
    protected $appendCompany = true;
    protected $validationRules = [
        'name' => 'required',
        'company_id' => 'required',
        'customer_id' => 'required',
    ];
}
