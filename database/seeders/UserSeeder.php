<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'email' => config('demo.admin.email'),
                'password' => config('demo.admin.password'),
                'name' => 'Admin Pustaka',
                'is_admin' => true,
            ],
            [
                'email' => config('demo.member.email'),
                'password' => config('demo.member.password'),
                'name' => 'Anggota Pustaka',
                'is_admin' => false,
            ],
        ];

        foreach ($accounts as $account) {

            if (
                !is_string($account['email']) ||
                trim($account['email']) === '' ||
                !is_string($account['password']) ||
                $account['password'] === ''
            ) {
                throw new \RuntimeException(
                    'Kredensial seeder harus diatur di file .env.'
                );
            }

            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make($account['password']),
                    'is_admin' => $account['is_admin'],
                ]
            );
        }
    }
}
