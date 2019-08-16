<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'customer_id',
        'url',
        'renewal_date',
        'status_id'
    ];

}

?>
