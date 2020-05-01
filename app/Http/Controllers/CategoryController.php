<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
    public function insert(Request $request){
        $category = new Category;
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->save();
    }

    public function Update(Request $request){
        $category = Category::find($request->get('id'));
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->save();
    }

    public function Delete(Request $request){
        Category::find($request->get('id'))->delete();
    }
}
