<?php

namespace App;

use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;


class ProductInquiry extends Model
{
    protected $guarded  = ['id'];
    
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    
}
