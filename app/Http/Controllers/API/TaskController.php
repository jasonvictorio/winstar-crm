<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class TaskController extends BaseController
{
    protected $modelString = 'Task';
    protected $with = ['company', 'project', 'status', 'task_category'];
    protected $appendCompany = true;
    protected $validationRules = [
        'name' => 'required',
        'company_id' => 'required',
        'project_id' => 'required',
    ];
}
