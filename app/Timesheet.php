<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    public $table = "timesheet";
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id', 
        'company_id', 
        'user_id', 
        'date', 
        'start_time', 
        'actual_time_spent', 
        'notes'
    ];
}

?>
