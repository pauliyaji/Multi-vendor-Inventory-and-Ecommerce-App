<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productionreport extends Model
{
    use HasFactory;

    protected $fillable =[
      'ptn_no',
      'total_qty',
      'total_price',
      'product_id',
      'date_of_ptn',
        'status',
        'remarks',
      'user_id',
    ];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function barcodes(){
        return $this->belongsTo(Barcode::class, 'ptn_no');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productionstatus(){
        return $this->belongsTo(Productionstatus::class, 'status');
    }


}
