<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'project_id', 
        'task_description', 
        'task_type_id', 
        'task_category_id', 
        'created_date', 
        'deadline_date', 
        'estimated_duration', 
        'priority_level', 
        'status', 
        'company_id'
    ];

    public $timestamps = false;
}

?>
