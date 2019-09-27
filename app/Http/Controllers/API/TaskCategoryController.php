<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class TaskCategoryController extends BaseController
{
    protected $modelString = 'TaskCategory';
    protected $appendUserCompany = true;
    protected $appendUser = true;
    protected $validationRules = [
        'name' => 'required',
    ];
}
