<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopinventory extends Model
{
    use HasFactory;

    protected $fillable = [
      'shop_id',
      'product_id',
        'barcode',
      'qty',
      'cost_price',
      'selling_price',
      'alert_qty',
    ];

    public function shops(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }


}
