<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class CustomerItem extends Model
{
    //
    protected $fillable = [
        'product_id',
        'customer_order_id',
        'invoice_frequency',
        'price',
        'line_number',
        'gst_id',
        'company_id'
    ];

}
