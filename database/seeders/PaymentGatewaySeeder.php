<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newPayment = new \App\Models\PaymentGateway;
        $newPayment->name = 'COD';
        $newPayment->number = 0;
        $newPayment->save();
    }
}
