<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $requiredTables = ['users', 'sellers', 'categories', 'products'];

        // Allow db:seed to be the first command on a fresh database.
        foreach ($requiredTables as $table) {
            if (! Schema::hasTable($table)) {
                Artisan::call('migrate', ['--force' => true]);
                break;
            }
        }

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // Truncate tables to avoid duplicates
        DB::table('products')->truncate();
        DB::table('sellers')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Insert specific user
        DB::table('users')->insert([
            'user_id' => 1,
            'username' => 'meliza_gabinete',
            'email' => 'meliza@example.com',
            'password_hash' => '$2y$10$hashedpassword',
            'first_name' => 'Meliza',
            'last_name' => 'Gabinete',
            'phone' => '09123456789',
            'address' => 'Cagayan de Oro, Philippines',
            'role' => 'customer',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Insert specific seller
        DB::table('sellers')->insert([
            'seller_id' => 1,
            'user_id' => 1,
            'business_name' => 'EJ Fresh Farm Produce',
            'business_address' => 'Bukidnon, Philippines',
            'business_phone' => '09987654321',
            'business_email' => 'ejdulay@farm.com',
            'tax_id' => 'TAX123456',
            'bank_account_details' => 'BDO 1234-5678-9012',
            'commission_rate' => 0.10,
            'is_verified' => true,
            'verification_documents' => '["verified_docs.pdf"]',
            'rating' => 4.8,
            'total_sales' => 1520,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Insert categories
        $categories = [
            [1, 'Leafy Greens', 'Fresh leafy vegetables rich in nutrients', true],
            [2, 'Berries', 'Sweet and antioxidant-rich berries', true],
            [3, 'Legumes', 'Protein-rich beans and peas', true],
            [4, 'Root Vegetables', 'Vegetables grown underground', true],
            [5, 'Tropical Fruits', 'Fruits grown in tropical climates', true],
            [6, 'Herbs', 'Fresh herbs for cooking and medicine', true],
            [7, 'Fresh Fruits', 'General fresh fruits selection', true],
            [8, 'Cruciferous', 'Vegetables like broccoli and cabbage', true],
            [9, 'Mushrooms', 'Edible fungi varieties', true],
            [10, 'Citrus Fruits', 'Tangy fruits rich in vitamin C', true],
            [11, 'Alliums', 'Garlic, onions, and related vegetables', true],
            [12, 'Organic', 'Certified organic produce', true]
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'category_id' => $cat[0],
                'category_name' => $cat[1],
                'category_description' => $cat[2],
                'category_isActive' => $cat[3],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Insert products
        $products = [
            [1, 'Fresh Spinach', 'Organic spinach leaves', 'Freshly harvested spinach from Bukidnon farms', 50.00, 45.00, 'SPN001', 'kg', 'fresh', 'Bukidnon', 1, 1, 100, now(), now(), true, 1, 5.00, true, true, false, false, 'EJ Farms', true, 200, now(), now(), 45.00],
            [2, 'Strawberries', 'Sweet fresh strawberries', 'Juicy strawberries rich in antioxidants', 150.00, 130.00, 'BER001', 'kg', 'fresh', 'Baguio', 1, 2, 50, now(), now(), true, 1, 20.00, true, true, false, false, 'EJ Farms', true, 150, now(), now(), 130.00],
            [3, 'Carrots', 'Crunchy carrots', 'Rich in beta-carotene and fiber', 60.00, 55.00, 'CRT001', 'kg', 'fresh', 'Bukidnon', 1, 4, 200, now(), now(), true, 1, 5.00, true, false, false, false, 'EJ Farms', false, 120, null, null, null],
            [4, 'Mangoes', 'Sweet Philippine mangoes', 'Premium Carabao mangoes', 120.00, 100.00, 'MNG001', 'kg', 'fresh', 'Davao', 1, 5, 80, now(), now(), true, 1, 20.00, true, true, false, false, 'EJ Farms', true, 300, now(), now(), 100.00],
            [5, 'Basil Leaves', 'Fresh basil herbs', 'Perfect for pasta and sauces', 40.00, null, 'HRB001', 'bundle', 'fresh', 'Bukidnon', 1, 6, 70, now(), now(), true, 1, 0.00, false, false, false, false, 'EJ Farms', false, 60, null, null, null]
        ];

        foreach ($products as $prod) {
            DB::table('products')->insert([
                'product_id' => $prod[0],
                'product_name' => $prod[1],
                'product_brief_description' => $prod[2],
                'product_detailed_description' => $prod[3],
                'product_price' => $prod[4],
                'product_discountedPrice' => $prod[5],
                'product_sku' => $prod[6],
                'product_unit' => $prod[7],
                'product_status' => $prod[8],
                'product_location' => $prod[9],
                'user_id' => $prod[10],
                'category_id' => $prod[11],
                'quantity' => $prod[12],
                'post_date' => $prod[13],
                'harvest_date' => $prod[14],
                'is_active' => $prod[15],
                'seller_id' => $prod[16],
                'discounted_amount' => $prod[17],
                'is_discounted' => $prod[18],
                'is_sale' => $prod[19],
                'is_srp' => $prod[20],
                'is_deleted' => $prod[21],
                'brand' => $prod[22],
                'top_rated' => $prod[23],
                'sell_count' => $prod[24],
                'offer_start_date' => $prod[25],
                'offer_end_date' => $prod[26],
                'promo_price' => $prod[27],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
