<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class StatusType extends Model
{
    protected $fillable = [
        'name',
        'company_id',
    ];

    protected $with = [
        'company'
    ];

    public function company()
    {
        return $this->belongsTo('\WinstarCRM\Company');
    }
}
