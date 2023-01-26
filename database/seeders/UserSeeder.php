<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    public function run() {
        $users = [
            [
                'name' => 'Super Admin',
                'phone' => '1234567890',
                'email' => 'superadmin@mail.com',
                'password' => bcrypt('Admin@123'),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ],
            [
                'name' => 'Gajjar Mitul',
                'phone' => '1234567899',
                'email' => 'gajjarmitul@yopmail.com',
                'password' => bcrypt('12345678'),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ],
            [
                'name' => 'Mustansir Makda',
                'phone' => '1234567809',
                'email' => 'mustan@yopmail.com',
                'password' => bcrypt('12345678'),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(

                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'phone' => $user['phone'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'status' => $user['status'],
                    'created_at' => $user['created_at'],
                    'created_by' => $user['created_by'],
                    'updated_at' => $user['updated_at'],
                    'updated_by' => $user['updated_by']
                ]
            );
        }
    }
}
