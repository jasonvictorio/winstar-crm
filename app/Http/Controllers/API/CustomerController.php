<?php

namespace WinstarCRM\Http\Controllers\API;

use WinstarCRM\Http\Controllers\API\BaseController;

class CustomerController extends BaseController
{
    protected $modelString = 'Customer';
    protected $with = ['company', 'status', 'nature_of_contact'];
}
