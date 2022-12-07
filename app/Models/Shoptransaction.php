<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoptransaction extends Model
{
    use HasFactory;

    protected $fillable =[
        'trx_no',
        'shop_id',
        'product_id',
        'qty',
        'cost_price',
        'total_price',
        'trxtype_id',
        'date_of_trx',
        'authorized_by',
    ];

    public function trxtypes(){
        return $this->belongsTo(Trxtype::class, 'trxtype_id');
    }

    public function shops(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'authorized_by');
    }

}
