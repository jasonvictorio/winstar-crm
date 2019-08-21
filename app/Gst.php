<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Gst extends Model
{
    //
    protected $fillable = [
        'company_id',
        'gst_amount',
        'gst_range',
    ];
}
