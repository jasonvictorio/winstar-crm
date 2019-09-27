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
        'name',
        'description',
        'created_date',
        'deadline_date',
        'project_id',
        'status_id',
        'task_type_id',
        'task_category_id',

        'user_id',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo('\WinstarCRM\Company');
    }
    public function status()
    {
        return $this->belongsTo('\WinstarCRM\Status');
    }
    public function project()
    {
        return $this->belongsTo('\WinstarCRM\Project');
    }
    public function task_type()
    {
        return $this->belongsTo('\WinstarCRM\TaskType');
    }
    public function task_category()
    {
        return $this->belongsTo('\WinstarCRM\TaskCategory');
    }
}

?>
