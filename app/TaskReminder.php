<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class TaskReminder extends Model
{
    public $table = "task_reminder";
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id','remind_date_time','subject','company_id'
    ];

    public $timestamps = false;
}

?>
