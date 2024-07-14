<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Payment extends Model{

    protected $fillable = [
        'product_id',
        'user_id',
        'voucher_id',
        'subtotal',
        'taxes',
        'total',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function voucher(){
        return $this->belongsTo(Voucher::class,'voucher_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}