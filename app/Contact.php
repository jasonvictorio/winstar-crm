<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','user_id','customer_id','first_name','surname','email','mobile'
    ];

    public $timestamps = false;
}

?>
