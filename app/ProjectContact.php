<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class ProjectContact extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'company_id',
        'contact_id'
    ];
}

?>
