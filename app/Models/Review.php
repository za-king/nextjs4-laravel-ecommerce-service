<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = "reviews";
    protected $keyType = "int";

    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ["comment", "ratting", "user_id", "product_id"];

    public function users()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function products()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
