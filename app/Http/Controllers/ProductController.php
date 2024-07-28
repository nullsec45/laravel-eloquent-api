<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\{ProductResource, ProductCollection};
use App\Models\{Category, Product};


class ProductController extends Controller
{
    public function index(){
        $products=Product::all();
        return new ProductCollection($products);
    }

    public function show(string $id){
        $products=Product::find($id);
        return new ProductResource($products);
    }

    public function paging(Request $request){
        $page=$request->get("page", 2);
        $products=Product::paginate(perPage:2, page:$page);
        return new ProductCollection($products);
    }
}
