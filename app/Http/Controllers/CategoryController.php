<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryAddRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory(CategoryAddRequest $request)
    {
        $data = $request->validated();

        $checkCategory = Category::where("name", $data["name"])->exists();
        if ($checkCategory) {
            return response()->json(["message" => "category already exists"]);
        }
        $category = new Category($data);
        $category->save();

        return new CategoryResource($category);
    }

    public function getAllCategory(Request $request)
    {
        $categories = Category::all();

        return response()->json(["data" => $categories]);
    }

    public function getByIdCategory(Request $request, $id)
    {
        $check = Category::where("id", $id)->exists();

        if ($check) {
            $category = Category::with('products')->find($id);
            return response()->json(["data" => $category], 200);
        } else {
            return response()->json(["message" => "category not found"], 404);
        }
    }

    public function removeCategory(Request $request, $id)
    {
        $check = Category::where("id", $id)->exists();

        if (!$check) {
            return response()->json(["message" => "id not found"]);
        }

        $Category = Category::find($id);
        $Category->delete();
        return response()->json(["message" => "Category deleted"], 202);

    }
}
