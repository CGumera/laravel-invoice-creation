<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePaymentType extends Model
{
    public function payment_type() {
        return $this->hasOne('App\PaymentType', 'id', 'payment_type_id');
    }
}
