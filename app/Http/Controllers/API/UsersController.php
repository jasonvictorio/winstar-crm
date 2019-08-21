<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class UsersController extends BaseController
{
    function __construct() {
        parent::__construct('users');
    }
}
