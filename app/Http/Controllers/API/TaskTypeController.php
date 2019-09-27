<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class TaskTypeController extends BaseController
{
    protected $modelString = 'TaskType';
    protected $appendUserCompany = true;
    protected $appendUser = true;
    protected $validationRules = [
        'name' => 'required',
    ];
}
