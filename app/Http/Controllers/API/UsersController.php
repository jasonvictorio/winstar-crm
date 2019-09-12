<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class UsersController extends BaseController
{
    protected $modelString = 'User';
    protected $with = ['company', 'access'];
}
