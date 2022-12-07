<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;

    protected $fillable = [

      'ptn_no',
        'output_qty',
        'product_id',
        'date_of_production',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
