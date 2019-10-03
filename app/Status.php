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
        'user_id',
        'name',
        'type'
    ];

    public function company()
    {
        return $this->belongsTo('\WinstarCRM\Company');
    }
}
?>
