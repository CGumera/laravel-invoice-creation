<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function products() {
        return $this->hasMany('App\InvoiceProduct');
    }

    public function payment_types() {
        return $this->hasMany('App\InvoicePaymentType');
    }
    
    public function getTaxPercentAttribute() {
        return $this->attributes['tax_percent'] * 100;
    } 
}
