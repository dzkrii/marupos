<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Outlet;
use App\Models\Payment;
use App\Models\Table;
use App\Models\TableArea;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ComprehensiveDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting comprehensive demo data seeding...');

        // Create demo company
        $this->command->info('📦 Creating company...');
        $company = Company::create([
            'name' => 'Resto Prima',
            'slug' => 'resto-prima',
            'phone' => '021-87654321',
            'email' => 'info@restoprima.com',
            'address' => 'Jl. Gatot Subroto No. 88, Jakarta Selatan',
            'subscription_plan' => 'professional',
            'subscription_expires_at' => now()->addYear(),
            'is_active' => true,
        ]);

        // Create main outlet
        $this->command->info('🏪 Creating outlet...');
        $outlet = Outlet::create([
            'company_id' => $company->id,
            'name' => 'Resto Prima - Gatsu',
            'slug' => 'gatsu',
            'code' => 'RP-JKT01',
            'phone' => '021-87654322',
            'address' => 'Jl. Gatot Subroto No. 88, Jakarta Selatan',
            'city' => 'Jakarta',
            'timezone' => 'Asia/Jakarta',
            'opening_time' => '10:00',
            'closing_time' => '23:00',
            'is_active' => true,
            'qr_access_code' => '123456',
        ]);

        // Create users with different roles
        $this->command->info('👥 Creating employees...');
        
        $owner = User::create([
            'company_id' => $company->id,
            'name' => 'Andi Prasetyo',
            'email' => 'owner@restoprima.com',
            'phone' => '08123456001',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $manager = User::create([
            'company_id' => $company->id,
            'name' => 'Lisa Kurniawan',
            'email' => 'manager@restoprima.com',
            'phone' => '08123456002',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Cashiers
        $cashiers = [];
        $cashierNames = ['Dian Safitri', 'Rudi Hermawan', 'Nina Sari'];
        foreach ($cashierNames as $index => $name) {
            $cashiers[] = User::create([
                'company_id' => $company->id,
                'name' => $name,
                'email' => 'kasir' . ($index + 1) . '@restoprima.com',
                'phone' => '08123456' . str_pad($index + 10, 3, '0', STR_PAD_LEFT),
                'pin' => str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);
        }

        // Waiters
        $waiters = [];
        $waiterNames = ['Budi Santoso', 'Sari Wulandari', 'Joko Widodo', 'Fitri Rahayu', 'Agus Salim'];
        foreach ($waiterNames as $index => $name) {
            $waiters[] = User::create([
                'company_id' => $company->id,
                'name' => $name,
                'email' => 'pelayan' . ($index + 1) . '@restoprima.com',
                'phone' => '08123456' . str_pad($index + 20, 3, '0', STR_PAD_LEFT),
                'pin' => str_pad($index + 100, 6, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);
        }

        // Kitchen Staff
        $kitchenStaff = [];
        $kitchenNames = ['Chef Budi', 'Chef Wati', 'Asisten Dapur 1', 'Asisten Dapur 2'];
        foreach ($kitchenNames as $index => $name) {
            $kitchenStaff[] = User::create([
                'company_id' => $company->id,
                'name' => $name,
                'email' => 'dapur' . ($index + 1) . '@restoprima.com',
                'phone' => '08123456' . str_pad($index + 30, 3, '0', STR_PAD_LEFT),
                'pin' => str_pad($index + 200, 6, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);
        }

        // Attach users to outlet with capabilities
        $owner->outlets()->attach($outlet->id, [
            'capabilities' => json_encode(['dashboard', 'menu_management', 'table_management', 'cashier', 'orders', 'kitchen', 'employees', 'reports']),
            'is_default' => true
        ]);

        $manager->outlets()->attach($outlet->id, [
            'capabilities' => json_encode(['dashboard', 'menu_management', 'table_management', 'cashier', 'orders', 'kitchen', 'employees', 'reports']),
            'is_default' => true
        ]);

        foreach ($cashiers as $cashier) {
            $cashier->outlets()->attach($outlet->id, [
                'capabilities' => json_encode(['dashboard', 'cashier', 'orders']),
                'is_default' => true
            ]);
        }

        foreach ($waiters as $waiter) {
            $waiter->outlets()->attach($outlet->id, [
                'capabilities' => json_encode(['dashboard', 'orders']),
                'is_default' => true
            ]);
        }

        foreach ($kitchenStaff as $staff) {
            $staff->outlets()->attach($outlet->id, [
                'capabilities' => json_encode(['dashboard', 'kitchen', 'orders']),
                'is_default' => true
            ]);
        }

        // Create menu categories
        $this->command->info('📋 Creating menu categories...');
        $categories = [
            ['name' => 'Appetizer', 'slug' => 'appetizer', 'icon' => '🥗', 'sort_order' => 1],
            ['name' => 'Makanan Utama', 'slug' => 'makanan-utama', 'icon' => '🍽️', 'sort_order' => 2],
            ['name' => 'Nasi & Mie', 'slug' => 'nasi-mie', 'icon' => '🍜', 'sort_order' => 3],
            ['name' => 'Seafood', 'slug' => 'seafood', 'icon' => '🦐', 'sort_order' => 4],
            ['name' => 'Ayam & Bebek', 'slug' => 'ayam-bebek', 'icon' => '🍗', 'sort_order' => 5],
            ['name' => 'Sop & Soto', 'slug' => 'sop-soto', 'icon' => '🥘', 'sort_order' => 6],
            ['name' => 'Minuman Panas', 'slug' => 'minuman-panas', 'icon' => '☕', 'sort_order' => 7],
            ['name' => 'Minuman Dingin', 'slug' => 'minuman-dingin', 'icon' => '🥤', 'sort_order' => 8],
            ['name' => 'Jus & Smoothies', 'slug' => 'jus-smoothies', 'icon' => '🧃', 'sort_order' => 9],
            ['name' => 'Dessert', 'slug' => 'dessert', 'icon' => '🍰', 'sort_order' => 10],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[$cat['slug']] = MenuCategory::create([
                'outlet_id' => $outlet->id,
                ...$cat,
            ]);
        }

        // Create extensive menu items
        $this->command->info('🍽️ Creating menu items...');
        $menuItems = [
            // Appetizer
            ['category' => 'appetizer', 'name' => 'Lumpia Semarang', 'price' => 25000, 'cost_price' => 10000, 'description' => 'Lumpia goreng isi sayuran dan rebung'],
            ['category' => 'appetizer', 'name' => 'Tahu Gejrot', 'price' => 15000, 'cost_price' => 5000, 'description' => 'Tahu goreng dengan kuah kecap pedas'],
            ['category' => 'appetizer', 'name' => 'Siomay Bandung', 'price' => 20000, 'cost_price' => 8000, 'description' => 'Siomay ikan dengan saus kacang'],
            ['category' => 'appetizer', 'name' => 'Onion Rings', 'price' => 22000, 'cost_price' => 9000, 'description' => 'Bawang bombay goreng tepung krispy'],
            ['category' => 'appetizer', 'name' => 'Salad Sayur', 'price' => 28000, 'cost_price' => 12000, 'description' => 'Sayuran segar dengan dressing pilihan'],

            // Makanan Utama
            ['category' => 'makanan-utama', 'name' => 'Steak Daging Sapi', 'price' => 85000, 'cost_price' => 45000, 'description' => 'Steak daging sapi premium dengan kentang tumbuk'],
            ['category' => 'makanan-utama', 'name' => 'Tenderloin Sauce Mushroom', 'price' => 95000, 'cost_price' => 50000, 'description' => 'Daging tenderloin dengan saus jamur'],
            ['category' => 'makanan-utama', 'name' => 'Grilled Chicken', 'price' => 55000, 'cost_price' => 25000, 'description' => 'Ayam panggang dengan saus BBQ'],
            ['category' => 'makanan-utama', 'name' => 'Fish & Chips', 'price' => 48000, 'cost_price' => 22000, 'description' => 'Ikan dory goreng dengan kentang goreng'],

            // Nasi & Mie
            ['category' => 'nasi-mie', 'name' => 'Nasi Goreng Spesial', 'price' => 35000, 'cost_price' => 15000, 'description' => 'Nasi goreng dengan telur, ayam, dan seafood'],
            ['category' => 'nasi-mie', 'name' => 'Nasi Goreng Kampung', 'price' => 28000, 'cost_price' => 12000, 'description' => 'Nasi goreng dengan ikan asin dan pete'],
            ['category' => 'nasi-mie', 'name' => 'Nasi Goreng Seafood', 'price' => 42000, 'cost_price' => 20000, 'description' => 'Nasi goreng dengan aneka seafood'],
            ['category' => 'nasi-mie', 'name' => 'Mie Goreng Jawa', 'price' => 30000, 'cost_price' => 13000, 'description' => 'Mie goreng dengan bumbu kecap manis'],
            ['category' => 'nasi-mie', 'name' => 'Mie Goreng Seafood', 'price' => 40000, 'cost_price' => 18000, 'description' => 'Mie goreng dengan udang dan cumi'],
            ['category' => 'nasi-mie', 'name' => 'Kwetiau Goreng', 'price' => 38000, 'cost_price' => 16000, 'description' => 'Kwetiau goreng dengan sapi dan sayuran'],
            ['category' => 'nasi-mie', 'name' => 'Bihun Goreng', 'price' => 32000, 'cost_price' => 14000, 'description' => 'Bihun goreng dengan sayuran'],

            // Seafood
            ['category' => 'seafood', 'name' => 'Udang Goreng Mentega', 'price' => 75000, 'cost_price' => 38000, 'description' => 'Udang goreng dengan saus mentega'],
            ['category' => 'seafood', 'name' => 'Cumi Goreng Tepung', 'price' => 58000, 'cost_price' => 28000, 'description' => 'Cumi goreng dengan tepung krispy'],
            ['category' => 'seafood', 'name' => 'Ikan Bakar Kecap', 'price' => 65000, 'cost_price' => 32000, 'description' => 'Ikan bakar dengan saus kecap pedas'],
            ['category' => 'seafood', 'name' => 'Kepiting Saus Padang', 'price' => 125000, 'cost_price' => 65000, 'description' => 'Kepiting dengan saus padang pedas gurih'],
            ['category' => 'seafood', 'name' => 'Kerang Hijau Saus Tiram', 'price' => 48000, 'cost_price' => 22000, 'description' => 'Kerang hijau tumis saus tiram'],

            // Ayam & Bebek
            ['category' => 'ayam-bebek', 'name' => 'Ayam Goreng Kremes', 'price' => 38000, 'cost_price' => 18000, 'description' => 'Ayam goreng dengan kremesan renyah'],
            ['category' => 'ayam-bebek', 'name' => 'Ayam Bakar Madu', 'price' => 45000, 'cost_price' => 22000, 'description' => 'Ayam bakar dengan saus madu'],
            ['category' => 'ayam-bebek', 'name' => 'Ayam Geprek', 'price' => 35000, 'cost_price' => 16000, 'description' => 'Ayam goreng geprek dengan sambal'],
            ['category' => 'ayam-bebek', 'name' => 'Bebek Goreng', 'price' => 55000, 'cost_price' => 28000, 'description' => 'Bebek goreng dengan sambal ijo'],
            ['category' => 'ayam-bebek', 'name' => 'Bebek Bakar', 'price' => 58000, 'cost_price' => 30000, 'description' => 'Bebek bakar dengan bumbu kecap'],

            // Sop & Soto
            ['category' => 'sop-soto', 'name' => 'Soto Betawi', 'price' => 38000, 'cost_price' => 16000, 'description' => 'Soto khas Betawi dengan santan'],
            ['category' => 'sop-soto', 'name' => 'Soto Ayam', 'price' => 32000, 'cost_price' => 14000, 'description' => 'Soto ayam kuning dengan telur'],
            ['category' => 'sop-soto', 'name' => 'Rawon', 'price' => 42000, 'cost_price' => 20000, 'description' => 'Sup daging dengan kluwek hitam'],
            ['category' => 'sop-soto', 'name' => 'Sop Buntut', 'price' => 65000, 'cost_price' => 32000, 'description' => 'Sup buntut sapi dengan sayuran'],
            ['category' => 'sop-soto', 'name' => 'Sop Iga', 'price' => 58000, 'cost_price' => 28000, 'description' => 'Sup iga sapi dengan kuah bening'],

            // Minuman Panas
            ['category' => 'minuman-panas', 'name' => 'Kopi Hitam', 'price' => 12000, 'cost_price' => 3000, 'description' => 'Kopi hitam original'],
            ['category' => 'minuman-panas', 'name' => 'Kopi Susu', 'price' => 15000, 'cost_price' => 5000, 'description' => 'Kopi dengan susu'],
            ['category' => 'minuman-panas', 'name' => 'Cappuccino', 'price' => 22000, 'cost_price' => 8000, 'description' => 'Espresso dengan foam susu'],
            ['category' => 'minuman-panas', 'name' => 'Cafe Latte', 'price' => 24000, 'cost_price' => 9000, 'description' => 'Espresso dengan steamed milk'],
            ['category' => 'minuman-panas', 'name' => 'Teh Tarik', 'price' => 12000, 'cost_price' => 4000, 'description' => 'Teh dengan susu kental manis'],
            ['category' => 'minuman-panas', 'name' => 'Teh Jahe', 'price' => 15000, 'cost_price' => 5000, 'description' => 'Teh hangat dengan jahe'],
            ['category' => 'minuman-panas', 'name' => 'Jeruk Panas', 'price' => 15000, 'cost_price' => 5000, 'description' => 'Air jeruk hangat dengan madu'],

            // Minuman Dingin
            ['category' => 'minuman-dingin', 'name' => 'Es Teh Manis', 'price' => 8000, 'cost_price' => 2000, 'description' => 'Teh manis dingin'],
            ['category' => 'minuman-dingin', 'name' => 'Es Jeruk', 'price' => 12000, 'cost_price' => 4000, 'description' => 'Air jeruk segar dengan es'],
            ['category' => 'minuman-dingin', 'name' => 'Es Teh Lemon', 'price' => 15000, 'cost_price' => 5000, 'description' => 'Teh dengan lemon segar'],
            ['category' => 'minuman-dingin', 'name' => 'Es Kopi Susu', 'price' => 18000, 'cost_price' => 6000, 'description' => 'Kopi susu dingin'],
            ['category' => 'minuman-dingin', 'name' => 'Ice Americano', 'price' => 20000, 'cost_price' => 7000, 'description' => 'Espresso dengan air dan es'],
            ['category' => 'minuman-dingin', 'name' => 'Ice Latte', 'price' => 26000, 'cost_price' => 10000, 'description' => 'Espresso dengan susu dingin'],

            // Jus & Smoothies
            ['category' => 'jus-smoothies', 'name' => 'Jus Alpukat', 'price' => 20000, 'cost_price' => 8000, 'description' => 'Jus alpukat segar'],
            ['category' => 'jus-smoothies', 'name' => 'Jus Mangga', 'price' => 18000, 'cost_price' => 7000, 'description' => 'Jus mangga manis'],
            ['category' => 'jus-smoothies', 'name' => 'Jus Strawberry', 'price' => 22000, 'cost_price' => 9000, 'description' => 'Jus strawberry segar'],
            ['category' => 'jus-smoothies', 'name' => 'Jus Melon', 'price' => 16000, 'cost_price' => 6000, 'description' => 'Jus melon segar'],
            ['category' => 'jus-smoothies', 'name' => 'Smoothie Bowl', 'price' => 35000, 'cost_price' => 15000, 'description' => 'Smoothie dengan topping buah dan granola'],
            ['category' => 'jus-smoothies', 'name' => 'Green Smoothie', 'price' => 28000, 'cost_price' => 12000, 'description' => 'Smoothie sayuran hijau dan buah'],

            // Dessert
            ['category' => 'dessert', 'name' => 'Es Cendol', 'price' => 15000, 'cost_price' => 5000, 'description' => 'Es cendol dengan santan dan gula merah'],
            ['category' => 'dessert', 'name' => 'Es Campur', 'price' => 18000, 'cost_price' => 7000, 'description' => 'Es dengan berbagai topping'],
            ['category' => 'dessert', 'name' => 'Kolak Pisang', 'price' => 12000, 'cost_price' => 4000, 'description' => 'Pisang dengan kuah santan manis'],
            ['category' => 'dessert', 'name' => 'Pisang Goreng Keju', 'price' => 18000, 'cost_price' => 6000, 'description' => 'Pisang goreng dengan topping keju'],
            ['category' => 'dessert', 'name' => 'Pancake', 'price' => 25000, 'cost_price' => 10000, 'description' => 'Pancake dengan madu dan mentega'],
            ['category' => 'dessert', 'name' => 'Ice Cream Sundae', 'price' => 30000, 'cost_price' => 12000, 'description' => 'Es krim dengan topping beragam'],
            ['category' => 'dessert', 'name' => 'Brownies', 'price' => 22000, 'cost_price' => 8000, 'description' => 'Brownies coklat hangat'],
            ['category' => 'dessert', 'name' => 'Tiramisu', 'price' => 35000, 'cost_price' => 15000, 'description' => 'Dessert Italia dengan kopi dan mascarpone'],
        ];

        $createdMenuItems = [];
        foreach ($menuItems as $index => $item) {
            $createdMenuItems[] = MenuItem::create([
                'outlet_id' => $outlet->id,
                'menu_category_id' => $createdCategories[$item['category']]->id,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'price' => $item['price'],
                'cost_price' => $item['cost_price'],
                'description' => $item['description'],
                'is_available' => true,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // Create table areas
        $this->command->info('🪑 Creating table areas and tables...');
        $tableAreas = [
            ['name' => 'Indoor - Main Hall', 'sort_order' => 1],
            ['name' => 'Indoor - Window Side', 'sort_order' => 2],
            ['name' => 'Outdoor - Terrace', 'sort_order' => 3],
            ['name' => 'VIP Room', 'sort_order' => 4],
            ['name' => 'Smoking Area', 'sort_order' => 5],
        ];

        $createdTableAreas = [];
        foreach ($tableAreas as $area) {
            $createdTableAreas[] = TableArea::create([
                'outlet_id' => $outlet->id,
                ...$area,
                'is_active' => true,
            ]);
        }

        // Create tables
        $tables = [];
        
        // Indoor - Main Hall (15 tables)
        for ($i = 1; $i <= 15; $i++) {
            $tables[] = Table::create([
                'outlet_id' => $outlet->id,
                'table_area_id' => $createdTableAreas[0]->id,
                'number' => 'M' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'capacity' => $i % 3 == 0 ? 6 : 4,
                'status' => 'available',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }

        // Indoor - Window Side (8 tables)
        for ($i = 1; $i <= 8; $i++) {
            $tables[] = Table::create([
                'outlet_id' => $outlet->id,
                'table_area_id' => $createdTableAreas[1]->id,
                'number' => 'W' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'name' => 'Window Table ' . $i,
                'capacity' => 2,
                'status' => 'available',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }

        // Outdoor - Terrace (10 tables)
        for ($i = 1; $i <= 10; $i++) {
            $tables[] = Table::create([
                'outlet_id' => $outlet->id,
                'table_area_id' => $createdTableAreas[2]->id,
                'number' => 'T' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'capacity' => $i % 2 == 0 ? 6 : 4,
                'status' => 'available',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }

        // VIP Room (3 rooms)
        for ($i = 1; $i <= 3; $i++) {
            $tables[] = Table::create([
                'outlet_id' => $outlet->id,
                'table_area_id' => $createdTableAreas[3]->id,
                'number' => 'V' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'name' => 'VIP Room ' . $i,
                'capacity' => 10,
                'status' => 'available',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }

        // Smoking Area (5 tables)
        for ($i = 1; $i <= 5; $i++) {
            $tables[] = Table::create([
                'outlet_id' => $outlet->id,
                'table_area_id' => $createdTableAreas[4]->id,
                'number' => 'S' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'capacity' => 4,
                'status' => 'available',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }

        // Create orders with various statuses
        $this->command->info('📋 Creating orders...');
        
        $orderStatuses = ['completed', 'completed', 'completed', 'ready', 'preparing', 'confirmed', 'pending'];
        $orderTypes = ['dine_in', 'dine_in', 'takeaway', 'dine_in', 'qr_order'];
        
        // Global order counter for unique order numbers
        $globalOrderCounter = 1;
        
        // Create orders for the last 30 days
        for ($day = 29; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);
            
            // Random number of orders per day (5-15 orders)
            $ordersPerDay = rand(5, 15);
            
            for ($i = 0; $i < $ordersPerDay; $i++) {
                $orderType = $orderTypes[array_rand($orderTypes)];
                $status = $day > 2 ? 'completed' : $orderStatuses[array_rand($orderStatuses)];
                
                // Random time during business hours (10:00 - 23:00)
                $hour = rand(10, 22);
                $minute = rand(0, 59);
                $orderTime = $date->copy()->setTime($hour, $minute);
                
                $table = $orderType === 'dine_in' || $orderType === 'qr_order' ? $tables[array_rand($tables)] : null;
                $waiter = $waiters[array_rand($waiters)];
                $cashier = $cashiers[array_rand($cashiers)];
                
                $order = Order::create([
                    'outlet_id' => $outlet->id,
                    'table_id' => $table?->id,
                    'user_id' => $waiter->id,
                    'order_number' => 'ORD-' . $orderTime->format('Ymd') . '-' . str_pad($globalOrderCounter++, 3, '0', STR_PAD_LEFT),
                    'order_type' => $orderType,
                    'status' => $status,
                    'customer_name' => $orderType === 'takeaway' || $orderType === 'delivery' ? $this->generateCustomerName() : null,
                    'customer_phone' => $orderType === 'takeaway' || $orderType === 'delivery' ? '08' . rand(1000000000, 9999999999) : null,
                    'guest_count' => rand(1, 6),
                    'created_at' => $orderTime,
                    'updated_at' => $orderTime,
                    'confirmed_at' => in_array($status, ['confirmed', 'preparing', 'ready', 'served', 'completed']) ? $orderTime->copy()->addMinutes(2) : null,
                    'completed_at' => $status === 'completed' ? $orderTime->copy()->addMinutes(rand(30, 90)) : null,
                ]);

                // Add random menu items to order (2-6 items)
                $itemCount = rand(2, 6);
                $selectedItems = array_rand($createdMenuItems, $itemCount);
                $selectedItems = is_array($selectedItems) ? $selectedItems : [$selectedItems];
                
                $subtotal = 0;
                
                foreach ($selectedItems as $itemIndex) {
                    $menuItem = $createdMenuItems[$itemIndex];
                    $quantity = rand(1, 3);
                    $itemSubtotal = $menuItem->price * $quantity;
                    $subtotal += $itemSubtotal;
                    
                    $itemStatus = match($status) {
                        'pending' => 'pending',
                        'confirmed' => 'pending',
                        'preparing' => 'preparing',
                        'ready' => 'ready',
                        'served' => 'served',
                        'completed' => 'served',
                        default => 'pending',
                    };
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $menuItem->id,
                        'menu_item_name' => $menuItem->name,
                        'unit_price' => $menuItem->price,
                        'quantity' => $quantity,
                        'subtotal' => $itemSubtotal,
                        'status' => $itemStatus,
                        'created_at' => $orderTime,
                        'updated_at' => $orderTime,
                    ]);
                }
                
                // Calculate totals
                $taxAmount = $subtotal * 0.10; // 10% tax
                $serviceCharge = $subtotal * 0.05; // 5% service charge
                $totalAmount = $subtotal + $taxAmount + $serviceCharge;
                
                $order->update([
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'service_charge' => $serviceCharge,
                    'total_amount' => $totalAmount,
                ]);

                // Create payment for completed orders
                if ($status === 'completed') {
                    $paymentMethod = ['cash', 'card', 'qris', 'transfer', 'ewallet'][array_rand(['cash', 'card', 'qris', 'transfer', 'ewallet'])];
                    $paidAt = $order->completed_at;
                    
                    $cashReceived = null;
                    $changeAmount = null;
                    
                    if ($paymentMethod === 'cash') {
                        $cashReceived = ceil($totalAmount / 10000) * 10000; // Round up to nearest 10k
                        $changeAmount = $cashReceived - $totalAmount;
                    }
                    
                    Payment::create([
                        'order_id' => $order->id,
                        'user_id' => $cashier->id,
                        'payment_method' => $paymentMethod,
                        'amount' => $totalAmount,
                        'cash_received' => $cashReceived,
                        'change_amount' => $changeAmount,
                        'status' => 'completed',
                        'paid_at' => $paidAt,
                        'created_at' => $paidAt,
                        'updated_at' => $paidAt,
                    ]);
                }
                
                // Update table status for active dine-in orders
                if ($table && in_array($status, ['confirmed', 'preparing', 'ready', 'served'])) {
                    $table->update(['status' => 'occupied']);
                }
            }
        }

        $this->command->info('');
        $this->command->info('✅ Comprehensive demo data seeded successfully!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('  - 1 Company created');
        $this->command->info('  - 1 Outlet created');
        $this->command->info('  - ' . (1 + 1 + count($cashiers) + count($waiters) + count($kitchenStaff)) . ' Employees created');
        $this->command->info('  - ' . count($categories) . ' Menu Categories created');
        $this->command->info('  - ' . count($createdMenuItems) . ' Menu Items created');
        $this->command->info('  - ' . count($createdTableAreas) . ' Table Areas created');
        $this->command->info('  - ' . count($tables) . ' Tables created');
        $this->command->info('  - ' . Order::count() . ' Orders created (last 30 days)');
        $this->command->info('  - ' . Payment::where('status', 'completed')->count() . ' Completed Payments');
        $this->command->info('');
        $this->command->info('🔑 Login Credentials:');
        $this->command->info('  Owner: owner@restoprima.com / password');
        $this->command->info('  Manager: manager@restoprima.com / password');
        $this->command->info('  Kasir 1: kasir1@restoprima.com / password (PIN: 000001)');
        $this->command->info('  Kasir 2: kasir2@restoprima.com / password (PIN: 000002)');
        $this->command->info('  Kasir 3: kasir3@restoprima.com / password (PIN: 000003)');
        $this->command->info('  Pelayan 1: pelayan1@restoprima.com / password (PIN: 000100)');
        $this->command->info('  Dapur 1: dapur1@restoprima.com / password (PIN: 000200)');
    }

    private function generateCustomerName(): string
    {
        $firstNames = ['Andi', 'Budi', 'Citra', 'Dian', 'Eka', 'Fitri', 'Gita', 'Hadi', 'Indra', 'Joko', 'Kartika', 'Lina', 'Maya', 'Nina', 'Omar'];
        $lastNames = ['Pratama', 'Santoso', 'Wijaya', 'Kurniawan', 'Sari', 'Hermawan', 'Rahayu', 'Saputra', 'Wulandari', 'Putra', 'Dewi', 'Susanto'];
        
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }
}
