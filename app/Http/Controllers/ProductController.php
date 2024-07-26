<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\{Category, Product};


class ProductController extends Controller
{
    public function show(string $id){
        $products=Product::find($id);
        return new ProductResource($products);
    }
}
