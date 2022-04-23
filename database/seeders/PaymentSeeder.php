<?php

namespace Database\Seeders;

use App\Models\ReferalSystemConfig;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReferalSystemConfig::insert([
            'referal_level' => '1',
            'percent' => '0.1'
        ]);
    }
}
