<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'batch_quantity',
        'product_code',
        'barcode',
    ];

    public function orderdetail(){
        return $this->hasMany(Orderdetail::class, 'product_id');
    }

    public function cart(){
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function shopinventories(){
        return $this->hasMany(Shopinventory::class, 'product_id');
    }
}
