<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Cenoura',
            'description' => 'descrição teste',
            'user_id' => 1
        ]);

        Product::create([
            'name' => 'Cebola',
            'description' => 'descrição teste',
            'user_id' => 1
        ]);
    }
}
