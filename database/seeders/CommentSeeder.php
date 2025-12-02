<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    protected array $comments = [
        'Is this still available?',
        'Interested! When can I pick up?',
        'What are the exact dimensions?',
        'Do you have more photos?',
        'Is shipping possible?',
        'Great item! Thanks for sharing.',
        'I had one like this, served me well for years!',
        'Perfect for what I need. Sending DM.',
        'Can you hold until Saturday?',
        'What neighborhood are you in?',
        'Does it come with all parts?',
        'Any known issues with it?',
        'How old is this item?',
        'Would you consider delivering for a fee?',
        'My friend needs one of these! Sharing.',
        'Such a generous offer!',
        'Community sharing at its best ',
        'I have a similar item if anyone needs.',
        'Can I see it tomorrow evening?',
        'Is it pet-friendly/safe?',
    ];

    protected array $replies = [
        'Yes, still available!',
        'Pickup anytime this week after 5pm.',
        'Dimensions are as listed in description.',
        'I can send more photos via email.',
        'Sorry, pickup only.',
        'You\'re welcome! Hope it helps someone.',
        'Sure, I can hold until Saturday.',
        'I\'m in downtown area.',
        'Comes with everything shown.',
        'No issues, works perfectly.',
        'About 2 years old.',
        'Sorry, no delivery available.',
        'Thanks for sharing!',
        'Tomorrow evening works, around 7pm?',
        'Yes, it\'s pet-safe.',
    ];

    public function run(): void
    {
        $listings = Listing::all();
        $users = User::all();

        foreach ($listings as $listing) {
            $commentCount = rand(0, 5);

            for ($i = 0; $i < $commentCount; $i++) {
                $comment = Comment::create([
                    'user_id' => $users->random()->id,
                    'listing_id' => $listing->id,
                    'content' => $this->comments[array_rand($this->comments)],
                    'created_at' => $listing->created_at->addDays(rand(1, 30)),
                ]);

                if (rand(1, 100) <= 30) {
                    $replyCount = rand(1, 3);

                    for ($j = 0; $j < $replyCount; $j++) {
                        Comment::create([
                            'user_id' => rand(0, 1) ? $listing->user_id : $users->random()->id,
                            'listing_id' => $listing->id,
                            'parent_id' => $comment->id,
                            'content' => $this->replies[array_rand($this->replies)],
                            'created_at' => $comment->created_at->addHours(rand(1, 48)),
                        ]);
                    }
                }
            }
        }

        foreach ($listings as $listing) {
            $listing->update([
                'comments_count' => $listing->allComments()->count(),
            ]);
        }

        $this->command->info(' Comments seeded successfully! (' . Comment::count() . ' comments created)');
    }
}
