<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['table_number', 'customer_id', 'status', 'user_id'];
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
