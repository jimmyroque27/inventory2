<?php
use App\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
      {
          $paytypes = [

              'Cash',
              'Check',
              'Credit Card',
              'ATM/Debit Card',
              'Bank Deposit',
              'GCash'
              'Receivables',

          ];

            foreach ($paytypes as $paytype) {
                 PaymentType::create(['name' => $paytype]);
                 // echo $paytype;
             }

    }
}
