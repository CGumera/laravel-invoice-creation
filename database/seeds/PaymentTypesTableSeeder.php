<?php

use Illuminate\Database\Seeder;
use App\PaymentType;

class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_type = new PaymentType;
        $payment_type->name = 'Cash';
        $payment_type->save();

        $payment_type = new PaymentType;
        $payment_type->name = 'Check';
        $payment_type->save();

        $payment_type = new PaymentType;
        $payment_type->name = 'Credit';
        $payment_type->save();
    }
}
