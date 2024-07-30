<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\{ProductResource, ProductCollection, ProductDebugResource};
use App\Models\{Category, Product};


class ProductController extends Controller
{
    public function index(){
        $products=Product::all();
        return new ProductCollection($products);
    }

    public function show(string $id){
        $products=Product::find($id);
        $products->load("category");
        return (new ProductResource($products))->response()->header("X-Powered-By","Fajar");
    }

    public function paging(Request $request){
        $page=$request->get("page", 2);
        $products=Product::paginate(perPage:2, page:$page);
        return new ProductCollection($products);
    }

    public function productDebug(string $id){
        $product=Product::find($id);
        return new ProductDebugResource($product);
    }
}
