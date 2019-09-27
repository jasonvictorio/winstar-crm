<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo('\WinstarCRM\Company');
    }
}

?>
