<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Voucher extends Model{

    protected $fillable = [
        'code',
        'discount_percent', 
        'product_id', 
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class,'voucher_id');
    }

}