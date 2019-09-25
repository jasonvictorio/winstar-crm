<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class NatureOfContact extends Model
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
