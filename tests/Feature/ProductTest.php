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

    public function testCollectionWrap(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $response=$this->get('/api/products/')
                       ->assertStatus(200);

        $names=$response->json("data.*.name");

        for($i=0;$i < 5; $i++){
            self::assertContains("Product $i of category Food", $names);
        }

        for($i=0;$i < 5; $i++){
            self::assertContains("Product $i of category Gadget", $names);
        }
    }

    public function testProductPaging(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $response=$this->get('/api/products-paging/')
                       ->assertStatus(200);

       self::assertNotNull($response->json("links"));
       self::assertNotNull($response->json("meta"));
       self::assertNotNull($response->json("data"));
    }

    public function testAdditionalMetaData(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product=Product::first();
        $response=$this->get("/api/products-debug/$product->id")
             ->assertStatus(200)
             ->assertJson([
                "author" => "Fajar",
                "data" => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "price" => $product->price
                ]
             ]);

        self::assertNotNull($response->json("server_time"));
    }

    public function testConditionalAttributes(): void
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
                    "is_expensive" => $product->price > 200,
                    "created_at" => $product->created_at->toJSON(),
                    "updated_at" => $product->updated_at->toJSON()
                ]
             ]);
    }

    public function testResourceCollection(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $response=$this->get("/api/products/")
                       ->assertStatus(200)
                       ->assertHeader("X-Powered-By","Fajar");

        $names=$response->json("data.*.name");

        for($i=0;$i < 5; $i++){
            self::assertContains("Product $i of category Food", $names);
        }

        for($i=0;$i < 5; $i++){
            self::assertContains("Product $i of category Gadget", $names);
        }
    }
}
