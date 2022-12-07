<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postrx extends Model
{
    use HasFactory;

    protected $fillable =[
        'pos_no',
        'shop_id',
        'customer_id',
        'product_id',
        'qty',
        'cost_price',
        'discount',
        'selling_price',
        'total_amount',
        'amount_paid',
        'balance',
        'paymentmethod_id',
        'postrxtype_id',
        'user_id',
    ];
}
