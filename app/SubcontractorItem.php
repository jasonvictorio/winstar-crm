<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class SubcontractorItems extends Model
{
    //
    protected $fillable = [
        'subcontractor_order_id',
        'product_id',
        'price',
        'line_number',
        'invoice_frequency',
        'gst_id',
        'company_id'
    ];

}
