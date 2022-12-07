<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'trx_no',
        'order_id',
        'product_id',
        'unitprice',
        'qty',
        'discount',
        'amount',

    ];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    public function shops(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
