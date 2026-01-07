<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Outlet;
use App\Models\Table;
use App\Models\TableArea;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo company
        $company = Company::create([
            'name' => 'Warung Nusantara',
            'slug' => 'warung-nusantara',
            'phone' => '021-12345678',
            'email' => 'info@warungnusantara.com',
            'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
            'subscription_plan' => 'pro',
            'subscription_expires_at' => now()->addYear(),
            'is_active' => true,
        ]);

        // Create outlets
        $outletJakarta = Outlet::create([
            'company_id' => $company->id,
            'name' => 'Warung Nusantara - Sudirman',
            'slug' => 'sudirman',
            'code' => 'WN-JKT01',
            'phone' => '021-11111111',
            'address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
            'city' => 'Jakarta',
            'timezone' => 'Asia/Jakarta',
            'opening_time' => '08:00',
            'closing_time' => '22:00',
            'is_active' => true,
        ]);

        $outletBandung = Outlet::create([
            'company_id' => $company->id,
            'name' => 'Warung Nusantara - Dago',
            'slug' => 'dago',
            'code' => 'WN-BDG01',
            'phone' => '022-22222222',
            'address' => 'Jl. Dago No. 88, Bandung',
            'city' => 'Bandung',
            'timezone' => 'Asia/Jakarta',
            'opening_time' => '09:00',
            'closing_time' => '21:00',
            'is_active' => true,
        ]);

        // Create users
        $owner = User::create([
            'company_id' => $company->id,
            'name' => 'Budi Santoso',
            'email' => 'owner@warungnusantara.com',
            'phone' => '08123456789',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $manager = User::create([
            'company_id' => $company->id,
            'name' => 'Siti Rahayu',
            'email' => 'manager@warungnusantara.com',
            'phone' => '08234567890',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $cashier = User::create([
            'company_id' => $company->id,
            'name' => 'Ahmad Wijaya',
            'email' => 'kasir@warungnusantara.com',
            'phone' => '08345678901',
            'pin' => '123456',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Attach users to outlets
        $owner->outlets()->attach($outletJakarta->id, ['role' => 'owner', 'is_default' => true]);
        $owner->outlets()->attach($outletBandung->id, ['role' => 'owner', 'is_default' => false]);

        $manager->outlets()->attach($outletJakarta->id, ['role' => 'manager', 'is_default' => true]);

        $cashier->outlets()->attach($outletJakarta->id, ['role' => 'cashier', 'is_default' => true]);

        // Create menu categories for Jakarta outlet
        $categories = [
            ['name' => 'Makanan Utama', 'slug' => 'makanan-utama', 'icon' => '🍛', 'sort_order' => 1],
            ['name' => 'Minuman', 'slug' => 'minuman', 'icon' => '🥤', 'sort_order' => 2],
            ['name' => 'Snack', 'slug' => 'snack', 'icon' => '🍟', 'sort_order' => 3],
            ['name' => 'Dessert', 'slug' => 'dessert', 'icon' => '🍰', 'sort_order' => 4],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[$cat['slug']] = MenuCategory::create([
                'outlet_id' => $outletJakarta->id,
                ...$cat,
            ]);
        }

        // Create menu items
        $menuItems = [
            // Makanan Utama
            ['category' => 'makanan-utama', 'name' => 'Nasi Goreng Spesial', 'price' => 35000, 'cost_price' => 15000],
            ['category' => 'makanan-utama', 'name' => 'Mie Goreng Seafood', 'price' => 40000, 'cost_price' => 18000],
            ['category' => 'makanan-utama', 'name' => 'Ayam Bakar Madu', 'price' => 45000, 'cost_price' => 22000],
            ['category' => 'makanan-utama', 'name' => 'Soto Betawi', 'price' => 38000, 'cost_price' => 16000],
            ['category' => 'makanan-utama', 'name' => 'Rendang Sapi', 'price' => 55000, 'cost_price' => 28000],

            // Minuman
            ['category' => 'minuman', 'name' => 'Es Teh Manis', 'price' => 8000, 'cost_price' => 2000],
            ['category' => 'minuman', 'name' => 'Es Jeruk', 'price' => 12000, 'cost_price' => 4000],
            ['category' => 'minuman', 'name' => 'Jus Alpukat', 'price' => 18000, 'cost_price' => 8000],
            ['category' => 'minuman', 'name' => 'Kopi Susu', 'price' => 15000, 'cost_price' => 5000],

            // Snack
            ['category' => 'snack', 'name' => 'Kentang Goreng', 'price' => 20000, 'cost_price' => 8000],
            ['category' => 'snack', 'name' => 'Pisang Goreng', 'price' => 15000, 'cost_price' => 5000],
            ['category' => 'snack', 'name' => 'Tahu Crispy', 'price' => 12000, 'cost_price' => 4000],

            // Dessert
            ['category' => 'dessert', 'name' => 'Es Cendol', 'price' => 15000, 'cost_price' => 5000],
            ['category' => 'dessert', 'name' => 'Kolak Pisang', 'price' => 12000, 'cost_price' => 4000],
        ];

        foreach ($menuItems as $index => $item) {
            MenuItem::create([
                'outlet_id' => $outletJakarta->id,
                'menu_category_id' => $createdCategories[$item['category']]->id,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'price' => $item['price'],
                'cost_price' => $item['cost_price'],
                'description' => 'Deskripsi untuk ' . $item['name'],
                'is_available' => true,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // Create table areas
        $indoor = TableArea::create([
            'outlet_id' => $outletJakarta->id,
            'name' => 'Indoor',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $outdoor = TableArea::create([
            'outlet_id' => $outletJakarta->id,
            'name' => 'Outdoor',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $vip = TableArea::create([
            'outlet_id' => $outletJakarta->id,
            'name' => 'VIP Room',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Create tables
        for ($i = 1; $i <= 8; $i++) {
            Table::create([
                'outlet_id' => $outletJakarta->id,
                'table_area_id' => $indoor->id,
                'number' => 'I' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'capacity' => 4,
                'status' => 'available',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }

        for ($i = 1; $i <= 4; $i++) {
            Table::create([
                'outlet_id' => $outletJakarta->id,
                'table_area_id' => $outdoor->id,
                'number' => 'O' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'capacity' => 6,
                'status' => 'available',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Table::create([
                'outlet_id' => $outletJakarta->id,
                'table_area_id' => $vip->id,
                'number' => 'V' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'name' => 'VIP Room ' . $i,
                'capacity' => 10,
                'status' => 'available',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }

        $this->command->info('Demo data seeded successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('  Owner: owner@warungnusantara.com / password');
        $this->command->info('  Manager: manager@warungnusantara.com / password');
        $this->command->info('  Kasir: kasir@warungnusantara.com / password');
    }
}
