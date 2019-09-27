<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $fillable = [
        'name',
        'company_id',
        'user_id',
    ];

    public function company()
    {
        return $this->belongsTo('\WinstarCRM\Company');
    }
}
