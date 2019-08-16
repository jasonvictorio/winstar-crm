<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    public $table = "task_type";
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'task_type'
    ];

    public $timestamps = false;
}

?>
