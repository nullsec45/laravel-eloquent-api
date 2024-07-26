<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\{CategorySeeder, ProductSeeder};
use App\Models\{Category, Product};


class ProductTest extends TestCase
{
  
    public function testProduct(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product=Product::first();


        $this->get("/api/products/$product->id")
             ->assertStatus(200)
             ->assertJson([
                "value" => [
                    "name" => $product->name,
                    "category" => [
                        "id" => $product->category->id,
                        "name" => $product->category->name,
                    ],
                    "price" => $product->price,
                    "created_at" => $product->created_at->toJSON(),
                    "updated_at" => $product->updated_at->toJSON()
                ]
             ]);
      
    }
}
