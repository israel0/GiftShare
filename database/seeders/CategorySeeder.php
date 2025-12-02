<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    protected array $categories = [
        ['name' => 'Electronics', 'description' => 'Phones, computers, gadgets, and electronic devices'],
        ['name' => 'Furniture', 'description' => 'Home and office furniture'],
        ['name' => 'Clothing & Accessories', 'description' => 'Clothes, shoes, bags, and accessories'],
        ['name' => 'Books & Media', 'description' => 'Books, magazines, DVDs, and CDs'],
        ['name' => 'Toys & Games', 'description' => 'Children toys, board games, and video games'],
        ['name' => 'Home & Garden', 'description' => 'Home decor, kitchenware, and garden tools'],
        ['name' => 'Sports & Fitness', 'description' => 'Sports equipment and fitness gear'],
        ['name' => 'Automotive', 'description' => 'Car parts, accessories, and tools'],
        ['name' => 'Tools & DIY', 'description' => 'Hand tools, power tools, and DIY materials'],
        ['name' => 'Baby & Kids', 'description' => 'Baby gear, strollers, and kids items'],
        ['name' => 'Musical Instruments', 'description' => 'Guitars, keyboards, drums, and other instruments'],
        ['name' => 'Art & Craft', 'description' => 'Art supplies, craft materials, and sewing items'],
        ['name' => 'Miscellaneous', 'description' => 'Other items that don\'t fit specific categories'],
    ];

    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => str($category['name'])->slug(),
                'description' => $category['description'],
                'created_at' => now()->subMonths(rand(1, 12)),
            ]);
        }

        $this->command->info(' Categories seeded successfully!');
    }
}
