<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            ListingSeeder::class,
            CommentSeeder::class,
            VoteSeeder::class,
        ]);

        $this->command->info(' Database seeding completed successfully!');
        $this->command->info(' Access the site at: http://localhost:8000');
        $this->command->info(' Admin login: admin@giftshare.com / admin123');
        $this->command->info(' Regular user: alex@example.com / password123');
    }
}
