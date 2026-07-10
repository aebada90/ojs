<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Marketplace\Models\Product;
use Modules\Vendor\Models\Vendor;
use Modules\Vendor\Models\VendorStore;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@oktoberfest.ai'],
            [
                'name' => 'Platform Admin',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('super_admin');

        $vendorUser = User::query()->firstOrCreate(
            ['email' => 'vendor@oktoberfest.ai'],
            [
                'name' => 'Bavaria Crafts Vendor',
                'username' => 'bavaria-crafts',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $vendorUser->assignRole('vendor');

        $vendor = Vendor::query()->firstOrCreate(
            ['slug' => 'bavaria-crafts'],
            [
                'user_id' => $vendorUser->id,
                'business_name' => 'Bavaria Crafts',
                'description' => 'Authentic Bavarian products and festival gear.',
                'status' => 'active',
                'is_verified' => true,
                'rating' => 4.8,
                'review_count' => 128,
            ]
        );

        VendorStore::query()->firstOrCreate(
            ['slug' => 'bavaria-crafts-store'],
            [
                'vendor_id' => $vendor->id,
                'name' => 'Bavaria Crafts Store',
                'tagline' => 'Traditional goods for modern festival lovers',
                'is_active' => true,
            ]
        );

        $category = Category::query()->firstOrCreate(
            ['slug' => 'festival-gear'],
            [
                'type' => 'product',
                'name' => 'Festival Gear',
                'is_active' => true,
            ]
        );

        $products = [
            ['name' => 'Traditional Lederhosen', 'price' => 189.00],
            ['name' => 'Bavarian Beer Stein', 'price' => 29.90],
            ['name' => 'Oktoberfest Dirndl', 'price' => 149.00],
            ['name' => 'Alpine Wool Blanket', 'price' => 79.00],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['vendor_id' => $vendor->id, 'slug' => Str::slug($product['name'])],
                [
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'summary' => 'Premium festival product from a verified vendor.',
                    'description' => 'Handcrafted for Oktoberfest and tourism experiences.',
                    'price' => $product['price'],
                    'stock' => 50,
                    'status' => 'published',
                    'is_featured' => true,
                    'rating' => 4.7,
                    'review_count' => 24,
                ]
            );
        }

        $listings = [
            ['type' => 'hotel', 'title' => 'Grand Munich Festival Hotel', 'price' => 220],
            ['type' => 'rental', 'title' => 'Vintage VW Camper Rental', 'price' => 95],
            ['type' => 'experience', 'title' => 'Private Beer Hall Tour', 'price' => 65],
            ['type' => 'restaurant', 'title' => 'Wiesn Biergarten & Kitchen', 'price' => 45],
            ['type' => 'event', 'title' => 'Opening Day Tent Reservation', 'price' => 35],
            ['type' => 'property', 'title' => 'Luxury Apartment near Theresienwiese', 'price' => 650000],
            ['type' => 'job', 'title' => 'Seasonal Festival Bartender', 'price' => 18],
        ];

        foreach ($listings as $listing) {
            Listing::query()->updateOrCreate(
                ['slug' => Str::slug($listing['title'])],
                [
                    'vendor_id' => $vendor->id,
                    'type' => $listing['type'],
                    'title' => $listing['title'],
                    'summary' => 'Featured '.$listing['type'].' listing for demo and development.',
                    'description' => 'Demo content seeded for the Oktoberfest AI platform homepage.',
                    'price' => $listing['price'],
                    'status' => 'published',
                    'is_featured' => true,
                    'rating' => 4.6,
                    'review_count' => 42,
                    'city' => 'Munich',
                    'country' => 'DE',
                    'published_at' => now(),
                ]
            );
        }
    }
}
