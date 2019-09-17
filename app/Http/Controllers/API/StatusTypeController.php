<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class StatusTypeController extends BaseController
{
    protected $modelString = 'StatusType';
    protected $with = ['company'];
    protected $appendUserCompany = true;
}
