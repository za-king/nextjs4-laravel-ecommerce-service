<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $primaryKey = "id";
    protected $keyType = "int";

    public $timestamps = true;
    public $incrementing = true;


    protected $fillable = [
        "name",
        "description",
        "image_url",
        "price",
        "stock",
        "category_id"
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, "product_id");
    }
}
