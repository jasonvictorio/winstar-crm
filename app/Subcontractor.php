<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Subcontractor extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','name','mobile','email','status'
    ];

    public $timestamps = false;
}

?>
