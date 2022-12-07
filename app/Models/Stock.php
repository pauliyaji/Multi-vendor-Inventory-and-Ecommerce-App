<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable =[
        'product_id',
        'qty',
        'alert_qty',
        'sku',
        'cost_price',
        'selling_price',

    ];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function barcodes(){
        return $this->belongsTo(Barcode::class, 'sku');
    }


}
