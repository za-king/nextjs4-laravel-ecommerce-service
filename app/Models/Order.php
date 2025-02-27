<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $table = "orders";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ["user_id", "total_price", "status"];

    public function users()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function ordersitems()
    {
        $this->hasMany(OrderItems::class, "order_id");
    }

    public function payments()
    {
        $this->hasMany(Payment::class, "order_id");
    }

}
