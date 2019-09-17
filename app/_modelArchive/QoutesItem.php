<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class QoutesItem extends Model
{
    //
    protected $fillable = [
        'qoute_id',
        'product_id',
        'invoice_frequency',
        'price',
        'line_number',
        'gst_id',
        'company_id'
    ];
}
