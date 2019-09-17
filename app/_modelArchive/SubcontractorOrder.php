<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class SubcontractorOrderTable extends Model
{
    //
    protected $fillable = [
        'subcontractor_id',
        'product_id',
        'company_id',
        'date_placed',
        'status_id',
        'user_id'
    ];
}
