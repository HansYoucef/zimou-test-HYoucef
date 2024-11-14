<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            WilayaSeeder::class,
            CommuneSeeder::class,
            DeliveryTypeSeeder::class,
            PackageStatusSeeder::class,
        ]);

        $stores = Store::factory()->count(5000)->create();
        $chunks = $stores->chunk(1000);
        $chunks->each(function($chunk) {
            foreach ($chunk as $store) {
                $packages = Package::factory()->count(100)->create([
                    'store_id' => $store['id']
                ]);
            }
        });
    }
}
