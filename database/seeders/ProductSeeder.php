<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::all()->each(function(Category $category){
            for($i=0;$i < 5;$i++){
                $category->products()->create([
                    "name" => "Product $i of category $category->name",
                    "price" => rand(100, 1000)
                ]);
            }
        });
    }
}
