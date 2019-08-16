<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'estimated_end_date',
        'status_id',
        'customer_id'
    ];

    public $timestamps = false;
}

?>
