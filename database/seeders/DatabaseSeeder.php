<?php

namespace Database\Seeders;

use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'test',
            'email' => 'test@user.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('12345678'),
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);

        Tariff::insert([
            'name' => 'base',
            'price' => 30.00,
            'description' => 'basic tariff',
            'limit' => 1000,
            'duration' => 30,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => '2',
            'model_type' => 'App\Models\User',
            'model_id' => '1',
        ]);
    }
}
