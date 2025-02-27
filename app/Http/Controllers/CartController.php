<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addCart(CartAddRequest $request)
    {
        //mitrans pass = Testing@996
        $data = $request->validated();

        // $checkUser = User::where("id", $data["user_id"])->exists();
        // $checkProduct = Product::where("id", $data["product_id"])->exists();

        $cartItem = Cart::where('user_id', $data['user_id'])
            ->where('product_id', $data['product_id'])
            ->first();

        if ($cartItem) {
            // Jika produk sudah ada, tambahkan jumlahnya
            $cartItem->quantity += $data['quantity'];
            $cartItem->save();
            return new CartResource($cartItem);
        } else {
            // Jika produk belum ada, buat baru
            $newData = Cart::create($data);
            return new CartResource($newData);
        }

    }
}
