<?php

namespace WinstarCRM;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'customer_id',
        'company_id',
        'invoice_date',
        'payment_method',
        'amount_paid'
    ];

}
