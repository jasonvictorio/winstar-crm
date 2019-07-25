<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class TaskReassignment extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id','reason','previous_user_id','current_user_id','date_time','company_id'
    ];

    public $timestamps = false;
}

?>
