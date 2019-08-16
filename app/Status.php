<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $table = "status";
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'status',
        'type'
    ];

    public $timestamps = false;
}

?>
