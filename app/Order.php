<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'order_no', 'user_id', 'product', 'shipping_address', 'shipping_code', 'price', 'fee', 'total', 'status', 'expired_at', 'payment_at'
    ];

    public function getPriceAttribute($value) {
        return number_format($value);
    }
    public function getTotalAttribute($value) {
        return number_format($value);
    }
    public function getStatusAttribute($value) {
        return ucfirst($value);
    }
}
