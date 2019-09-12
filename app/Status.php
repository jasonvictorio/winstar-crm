<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $table = "status";
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'status',
        'type'
    ];

    protected $hidden = [
        'company_id',
        'status_type_id',
    ];

    protected $with = [
        'company',
        'status_type',
    ];

    public function company()
    {
        return $this->belongsTo('\WinstarCRM\Company');
    }

    public function status_type_id()
    {
        return $this->belongsTo('\WinstarCRM\StatusType');
    }
}
?>
