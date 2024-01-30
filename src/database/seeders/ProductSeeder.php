<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $possibleNames = [
            "Celular", "Notebook", "Computador", "Tablet", "Smartphone", "Smartwatch"
        ];

        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => $possibleNames[array_rand($possibleNames)],
                'price' => mt_rand(100, 1000),
                'description' => Str::random(10)
            ]);
        }

    }
}
