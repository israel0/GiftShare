<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
     protected array $users = [
        [
            'name' => 'Alex Johnson',
            'email' => 'alex@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'Maria Garcia',
            'email' => 'maria@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'David Smith',
            'email' => 'david@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'Sarah Chen',
            'email' => 'sarah@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'James Wilson',
            'email' => 'james@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'Emma Brown',
            'email' => 'emma@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'Michael Taylor',
            'email' => 'michael@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'Lisa Martinez',
            'email' => 'lisa@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'Robert Lee',
            'email' => 'robert@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'Jennifer Davis',
            'email' => 'jennifer@example.com',
            'password' => 'password123',
        ],
    ];

    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@giftshare.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        foreach ($this->users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'email_verified_at' => now()->subDays(rand(1, 90)),
                'created_at' => now()->subMonths(rand(1, 6)),
            ]);
        }

        User::factory()->count(10)->create([
            'email_verified_at' => now(),
            'created_at' => now()->subDays(rand(1, 180)),
        ]);

        $this->command->info(' Users seeded successfully!');
        $this->command->info('Admin login: admin@giftshare.com / admin123');
        $this->command->info('Regular user: alex@example.com / password123');
    }
}
