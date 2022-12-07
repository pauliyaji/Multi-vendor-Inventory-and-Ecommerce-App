<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
      'product_id',
      'qty',
      'selling_price',
        'discount',
        'total_price',
      'user_id',
      'shop_id',
    ];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
