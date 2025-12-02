<?php

namespace Database\Seeders;

use App\Models\Vote;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    public function run(): void
    {
        $listings = Listing::all();
        $users = User::all();

        foreach ($listings as $listing) {

            $voterCount = rand(0, 15);
            $voters = $users->random(min($voterCount, $users->count()));

            $upvotes = 0;
            $downvotes = 0;

            foreach ($voters as $user) {
                $type = rand(1, 100) <= 80 ? 'upvote' : 'downvote';

                Vote::create([
                    'user_id' => $user->id,
                    'listing_id' => $listing->id,
                    'type' => $type,
                    'created_at' => $listing->created_at->addDays(rand(1, 60)),
                ]);

                if ($type === 'upvote') {
                    $upvotes++;
                } else {
                    $downvotes++;
                }
            }

            $listing->update([
                'upvotes_count' => $upvotes,
                'downvotes_count' => $downvotes,
            ]);
        }

        $this->command->info(' Votes seeded successfully! (' . Vote::count() . ' votes created)');
    }
}
