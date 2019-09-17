<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Qoutes extends Model
{
    protected $fillable = [
        'customer_id',
        'qoute_item_id',
        'company_id',
        'date_placed',
        'status_id',
        'qoute_by',

    ];
}
