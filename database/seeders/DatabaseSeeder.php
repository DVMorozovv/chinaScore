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
            'name' => 'admin',
            'phone' => '(111) 111-1111',
            'email' => 'admin@admin.com',
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
            'items_limit' => 1000,
            'duration' => 30,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);

        Tariff::insert([
            'name' => 'default',
            'price' => 200.00,
            'description' => 'базовый тариф, используется, когда у пользователя нет подписки. Название тарифа всегда должно быть "default"',
            'limit' => 1000,
            'items_limit' => 1000,
            'duration' => 30,
            'is_active' => 0,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'name' => 'user',
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
            'guard_name' => 'web2',
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => '2',
            'model_type' => 'App\Models\User',
            'model_id' => '1',
        ]);


    }
}
