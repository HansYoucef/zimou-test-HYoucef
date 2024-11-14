<?php

namespace Database\Seeders;

use App\Models\PackageStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageStatusSeeder extends Seeder
{
    protected $packageStatuses = [
        ['name' => 'Prêt pour le ramassage'],
        ['name' => 'Récupéré'],
        ['name' => 'En Attente'],
        ['name' => 'En Transit'],
        ['name' => 'En Cours de livraison'],
        ['name' => 'Tentative de livraison'],
        ['name' => 'Livré'],
        ['name' => 'Retour à l\'expediteur'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PackageStatus::insert($this->packageStatuses);
    }
}
