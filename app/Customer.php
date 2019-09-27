<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'user_id',
        'status_id',
        'nature_of_contact_id',
        'next_follow_up_date',
        'first_name',
        'last_name',
        'hear_about_us',
        'first_contacted',
        'last_contacted',
        'notes',
    ];

    protected $appends = ['name'];

    public function company()
    {
        return $this->belongsTo('\WinstarCRM\Company');
    }
    public function status()
    {
        return $this->belongsTo('\WinstarCRM\Status');
    }
    public function nature_of_contact()
    {
        return $this->belongsTo('\WinstarCRM\NatureOfContact');
    }
    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
}

?>
