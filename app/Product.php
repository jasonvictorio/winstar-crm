<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'product_category_id',
        'company_id',
        'product_name',
        'price',
    ];
}
