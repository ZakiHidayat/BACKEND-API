<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Samsung S3', 'Macbook Pro M1 2021'];
        foreach ($names as $value) {
            Product::create([
                'name' => $value,
                'price' => '' . rand(1000000, 15000000)
            ]);
        }

    }
}