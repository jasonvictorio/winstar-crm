<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    public $table = "task_category";
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'category_name'
    ];
}

?>
