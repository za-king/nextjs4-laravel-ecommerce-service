<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $keyType = "int";
    protected $table = "carts";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ["user_id", "product_id", "quantity", "price"];

    public function users()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function products()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
