<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAddRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(ProductAddRequest $request)
    {

        $data = $request->validated();

        $check = Product::where("name", $data["name"])->exists();

        if ($check) {
            return response()->json(["message" => "product already exists"]);
        }



        if ($request->hasFile("image_url")) {
            $path = $request->file('image_url')->store('products', 'public');
            $data["image_url"] = asset("storage/{$path}");
        }

        $product = new Product($data);
        $product->save();
        return new ProductResource($product);
    }

    public function getAllProduct(Request $request)
    {

        $products = Product::all();

        return response()->json(["data" => $products], 200);
    }

    public function removeProduct(Request $request, $id)
    {
        $check = Product::where("id", $id)->exists();

        if (!$check) {
            return response()->json(["message" => "id not found"]);
        }

        $product = Product::find($id);
        $product->delete();
        return response()->json(["message" => "product deleted"], 202);

    }

    public function getByIdProduct(Request $request, $id)
    {
        $check = Product::where("id", $id)->exists();

        if (!$check) {
            return response()->json(["message" => "product not found"]);
        }

        $product = Product::with("reviews")->find($id);

        return response()->json(["data" => $product]);
    }
}
