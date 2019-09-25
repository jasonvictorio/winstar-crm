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
        'name',
        'status_type_id',
        'type'
    ];

    public function company()
    {
        return $this->belongsTo('\WinstarCRM\Company');
    }

    public function status_type()
    {
        return $this->belongsTo('\WinstarCRM\StatusType');
    }
}
?>
