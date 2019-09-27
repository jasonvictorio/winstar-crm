<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'estimated_end_date',
        'customer_id',
        'status_id',
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
    public function customer()
    {
        return $this->belongsTo('\WinstarCRM\Customer');
    }
}

?>
