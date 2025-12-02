<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ListingSeeder extends Seeder
{
    protected array $listings = [
        [
            'title' => 'Vintage Wooden Desk',
            'description' => 'Beautiful vintage wooden desk in excellent condition. Made from solid oak, perfect for home office. Some minor scratches but overall great condition.',
            'city' => 'New York',
            'weight' => 35.5,
            'dimensions' => '150x75x75 cm',
            'status' => 'available',
        ],
        [
            'title' => 'iPhone 12 Pro Max 256GB',
            'description' => 'Fully functional iPhone 12 Pro Max with 256GB storage. Comes with original box, charger, and a clear case. Screen protector installed.',
            'city' => 'Los Angeles',
            'weight' => 0.228,
            'dimensions' => null,
            'status' => 'available',
        ],
        [
            'title' => 'Leather Sofa Set (3 Pieces)',
            'description' => '3-piece genuine leather sofa set in excellent condition. Smoke-free home. Perfect for large living room. Slight wear on armrests.',
            'city' => 'Chicago',
            'weight' => 180.0,
            'dimensions' => 'L-shaped, fits in 4x3 meter space',
            'status' => 'gifted',
        ],
        [
            'title' => 'Kitchen Mixer - Brand New',
            'description' => 'Brand new kitchen mixer, still in box. Received as gift but already have one. 5-speed settings with dough hooks and beaters.',
            'city' => 'Houston',
            'weight' => 5.2,
            'dimensions' => '30x20x25 cm',
            'status' => 'available',
        ],
        [
            'title' => 'Complete Harry Potter Book Set',
            'description' => 'Complete Harry Potter hardcover book set. All 7 books in great condition. Perfect for collectors or new readers.',
            'city' => 'Phoenix',
            'weight' => 8.5,
            'dimensions' => null,
            'status' => 'available',
        ],
        [
            'title' => 'Mountain Bike - Medium Size',
            'description' => 'Mountain bike in good condition. 21-speed, front suspension. Recently serviced with new brake pads. Suitable for adults 5\'6" to 6\'0".',
            'city' => 'Philadelphia',
            'weight' => 15.8,
            'dimensions' => 'Medium frame',
            'status' => 'gifted',
        ],
        [
            'title' => 'Yamaha Acoustic Guitar',
            'description' => 'Yamaha F310 acoustic guitar. Great for beginners. Comes with gig bag and extra strings. Needs minor tuning adjustment.',
            'city' => 'San Antonio',
            'weight' => 3.2,
            'dimensions' => 'Full size',
            'status' => 'available',
        ],
        [
            'title' => 'Patio Furniture Set',
            'description' => 'Outdoor patio furniture set: table and 4 chairs. Weather-resistant material. Some fading from sun exposure but structurally sound.',
            'city' => 'San Diego',
            'weight' => 45.0,
            'dimensions' => 'Table: 150cm diameter',
            'status' => 'available',
        ],
        [
            'title' => 'Professional Camera Tripod',
            'description' => 'Professional camera tripod, carbon fiber. Extends to 180cm, folds to 50cm. Includes carrying case. Used only a few times.',
            'city' => 'Dallas',
            'weight' => 2.1,
            'dimensions' => 'Folded: 50cm',
            'status' => 'available',
        ],
        [
            'title' => 'Children\'s Wooden Play Kitchen',
            'description' => 'Wooden play kitchen for children. Includes pretend sink, stove, and oven. Some paint chipping but safe and functional.',
            'city' => 'San Jose',
            'weight' => 12.5,
            'dimensions' => '80x40x100 cm',
            'status' => 'gifted',
        ],
    ];

    protected array $cities = [
        'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix',
        'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose',
        'Austin', 'Jacksonville', 'Fort Worth', 'Columbus', 'Charlotte',
        'San Francisco', 'Indianapolis', 'Seattle', 'Denver', 'Washington',
        'Boston', 'El Paso', 'Nashville', 'Detroit', 'Portland'
    ];

    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        // Create featured listings
        foreach ($this->listings as $listingData) {
            $listing = Listing::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title' => $listingData['title'],
                'slug' => Str::slug($listingData['title']) . '-' . Str::random(6),
                'description' => $listingData['description'],
                'city' => $listingData['city'],
                'weight' => $listingData['weight'],
                'dimensions' => $listingData['dimensions'],
                'status' => $listingData['status'],
                'upvotes_count' => rand(0, 50),
                'downvotes_count' => rand(0, 10),
                'comments_count' => rand(0, 15),
                'gifted_at' => $listingData['status'] === 'gifted' ? now()->subDays(rand(1, 30)) : null,
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        // Create additional random listings
        $titles = [
            'Bookshelf - Solid Wood', 'Coffee Table Glass Top', 'Office Chair Ergonomic',
            'Baby Crib with Mattress', 'Tennis Racket Professional', 'Skateboard Complete',
            'Microwave Oven 1000W', 'Blender 8-Speed', 'Toaster 4-Slice',
            'Lamp Floor Standing', 'Rug 8x10 Persian Style', 'Curtains Thermal Lined',
            'Desk Lamp LED', 'Keyboard Mechanical', 'Monitor 24 inch HD',
            'Prinkter Laser Wireless', 'Scanner Document', 'Projector HD 1080p',
            'Tent 4-Person Camping', 'Sleeping Bag -20°C', 'Backpack 60L Hiking',
            'Fishing Rod Set', 'Golf Clubs Set', 'Yoga Mat Premium',
            'Dumbbells 20kg Set', 'Treadmill Electric', 'Exercise Bike',
            'Sewing Machine Vintage', 'Knitting Needles Set', 'Paint Brushes Artist',
            'Easel Wooden', 'Canvas Stretched', 'Clay Pottery Wheel',
            'Violin Student Model', 'Keyboard 61 Keys', 'Drum Set Electronic',
            'Microphone Condenser', 'Speaker Bluetooth', 'Headphones Noise Cancelling',
            'Watch Analog Leather', 'Sunglasses Designer', 'Wallet Leather',
            'Suitcase 28 inch', 'Backpack Laptop', 'Lunch Box Insulated',
            'Water Bottle Stainless', 'Umbrella Large', 'Gardening Tools Set',
            'Lawn Mower Electric', 'Hose 50ft', 'Plant Pots Ceramic',
        ];

        for ($i = 0; $i < 40; $i++) {
            $title = $titles[array_rand($titles)] . ' ' . ($i % 5 + 1);
            $status = rand(0, 1) ? 'available' : 'gifted';

            Listing::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . Str::random(6),
                'description' => $this->generateDescription(),
                'city' => $this->cities[array_rand($this->cities)],
                'weight' => rand(0, 1) ? rand(1, 100) + (rand(0, 99) / 100) : null,
                'dimensions' => rand(0, 1) ? rand(10, 200) . 'x' . rand(10, 200) . 'x' . rand(10, 200) . ' cm' : null,
                'status' => $status,
                'upvotes_count' => rand(0, 35),
                'downvotes_count' => rand(0, 8),
                'comments_count' => rand(0, 12),
                'gifted_at' => $status === 'gifted' ? now()->subDays(rand(1, 60)) : null,
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now()->subDays(rand(0, 60)),
            ]);
        }

        $this->command->info('Listings seeded successfully! (' . Listing::count() . ' listings created)');
    }

    protected function generateDescription(): string
    {
        $descriptions = [
            'In good condition, used but well maintained. Perfect for someone who needs it.',
            'Slight wear and tear but fully functional. Free to a good home.',
            'Recently replaced with new model. This one still has plenty of life left.',
            'Works perfectly, just clearing out space. Pickup preferred.',
            'Great item, served me well. Hope it can help someone else.',
            'Minor cosmetic issues but works as intended. No returns please.',
            'From a smoke-free, pet-free home. Clean and ready to use.',
            'Selling because I no longer need it. First come first served.',
            'Perfect for students or someone on a budget. Everything works.',
            'Includes all accessories shown. Battery may need replacement.',
            'Some scratches from normal use but nothing affecting functionality.',
            'Great starter item for beginners. Comes with basic instructions.',
            'Moving soon, need to declutter. Available for immediate pickup.',
            'Received as gift but already have one. Brand new condition.',
            'Used only a few times. Like new condition. No shipping available.',
        ];

        return $descriptions[array_rand($descriptions)];
    }
}
