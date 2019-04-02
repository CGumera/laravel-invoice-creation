<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    public function product() {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
