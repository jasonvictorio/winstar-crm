<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address',
    ];

    public $timestamps = false;
}

?>
