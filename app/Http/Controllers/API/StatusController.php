<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class StatusController extends BaseController
{
    protected $modelString = 'Status';
    protected $with = ['company', 'status_type'];
    protected $appendUserCompany = true;
    protected $validationRules = [
        'name' => 'required',
        'status_type_id' => 'required',
    ];
}
