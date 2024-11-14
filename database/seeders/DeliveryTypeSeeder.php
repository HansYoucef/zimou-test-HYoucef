<?php

namespace Database\Seeders;

use App\Models\DeliveryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryTypeSeeder extends Seeder
{

    protected $deliveryTypes = [
        ['name' => 'Domicile'],
        ['name' => 'Express'],
        ['name' => 'Point de relais'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryType::insert($this->deliveryTypes);
    }
}
