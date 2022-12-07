<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'trx_no',
        'amount_paid',
        'balance',
        'total_amount',
        'paymentmethod_id',
        'trxtype_id',
        'user_id',
        'shop_id',
        'trx_date',
    ];

    public function shops(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }
    public function orders(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function trxtypes(){
        return $this->belongsTo(Trxtype::class, 'trxtype_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
