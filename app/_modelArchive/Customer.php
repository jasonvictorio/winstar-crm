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
        'next_follow_up_date', 
        'latest_contact_or_actions', 
        'nature_of_contact', 
        'notes', 
        'first_contacted', 
        'last_contacted', 
        'days_since_last_contact', 
        'status_id', 
        'month_ordered', 
        'package_ordered', 
        'hear_about_us', 
        'up_sell','quote_total', 
        'addons', 
        'total', 
        'invoiced', 
        'annual_renewal_date', 
        'annual_renewal_amount'
    ];
}

?>
