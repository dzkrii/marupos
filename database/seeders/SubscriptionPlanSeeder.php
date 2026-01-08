<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Untuk restoran kecil yang baru mulai',
                'price_monthly' => 299000,
                'price_yearly' => 2870400, // 20% discount
                'max_outlets' => 1,
                'max_tables' => 20,
                'max_employees' => 5,
                'features' => [
                    'POS & Menu Management',
                    'QR Order',
                    '1 Outlet',
                    'Maksimal 20 Meja',
                    'Maksimal 5 Karyawan',
                    'Laporan Dasar',
                    'Email Support',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Untuk restoran yang berkembang',
                'price_monthly' => 599000,
                'price_yearly' => 5750400, // 20% discount
                'max_outlets' => 3,
                'max_tables' => null, // Unlimited
                'max_employees' => 20,
                'features' => [
                    'Semua Fitur Starter',
                    'Hingga 3 Outlet',
                    'Meja Unlimited',
                    'Hingga 20 Karyawan',
                    'Kitchen Display System',
                    'Laporan Lengkap + Export PDF',
                    'Manajemen Karyawan',
                    'Priority Support',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Untuk jaringan restoran besar',
                'price_monthly' => 0, // Custom pricing
                'price_yearly' => 0, // Custom pricing
                'max_outlets' => null, // Unlimited
                'max_tables' => null, // Unlimited
                'max_employees' => null, // Unlimited
                'features' => [
                    'Semua Fitur Professional',
                    'Outlet Unlimited',
                    'Karyawan Unlimited',
                    'Dedicated Account Manager',
                    'Custom Integration & API',
                    'SLA Guarantee 99.9%',
                    'On-site Training',
                    'White Label Option',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
