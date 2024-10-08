<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\{CategoryResource, CategoryCollection};



class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        return CategoryResource::collection($categories);
    }

    public function show(String $id){
        $category=Category::findOrFail($id);
        return new CategoryResource($category);
    }

    public function categoryCustom(){
        $categories=Category::all();
        return new CategoryCollection($categories);
    }
}
