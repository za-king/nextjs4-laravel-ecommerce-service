<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $table = "order_items";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ["order_id", "product_id", "quantity", "price"];

    protected function orders()
    {
        $this->belongsTo(Order::class, "order_id");
    }

    protected function products()
    {
        $this->belongsTo(Product::class, "product_id");
    }
}
