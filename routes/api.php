<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//USERS
Route::post("/users/register", [UserController::class, "register"]);
Route::post("/users/login", [UserController::class, "login"])->name('login');
Route::post('/users/refresh-token', [UserController::class, 'refreshToken']);


Route::middleware("auth:sanctum")->group(function () {
    Route::post("/users/logout", [UserController::class, "logout"]);
    Route::get("/users/getAll", [UserController::class, "getAll"]);

    //CATEGORIES
    Route::post("/categories/add", [CategoryController::class, "addCategory"]);
    Route::get("/categories/getAll", [CategoryController::class, "getAllCategory"]);
    Route::get("/categories/getById/{id}", [CategoryController::class, "getByIdCategory"]);
    Route::delete("/categories/remove/{id}", [CategoryController::class, "removeCategory"]);
    //PRODUCTS
    Route::post("/products/add", [ProductController::class, "addProduct"]);
    Route::get("/products/getAll", [ProductController::class, "getAllProduct"]);
    Route::get("/products/getById/{id}", [ProductController::class, "getByIdProduct"]);
    Route::delete("/products/remove/{id}", [ProductController::class, "removeProduct"]);
    //REVIEWS
    Route::post("/reviews/add", [ReviewController::class, "addReview"]);
});