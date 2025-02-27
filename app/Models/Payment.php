<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $table = "payments";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ["order_id", "payment_method", "payment_status", "transaction_id"];

    public function orders()
    {
        return $this->belongsTo(Order::class, "order_id");
    }

}
