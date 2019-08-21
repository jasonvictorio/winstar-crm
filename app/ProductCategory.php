<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    //
    protected $fillable = [
        'category_name',
        'company_id',
    ];
}
