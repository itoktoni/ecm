<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@kepompong.id',
                'name' => 'Admin User',
                'role' => 'developer',
                'subscribe' => 1,
                'verified_at' => date('Y-m-d H:i:s'),
                'email_verified_at' => date('Y-m-d H:i:s'),
            ],
            [
                'email' => 'user@kepompong.id',
                'name' => 'Admin User',
                'role' => 'user',
                'subscribe' => 1,
                'verified_at' => date('Y-m-d H:i:s'),
                'email_verified_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['password' => bcrypt(env('PASSWORD', 'password'))])
            );
        }
    }
}
