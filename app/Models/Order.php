<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'trx_no',
      'shop_id',
      'customer_id'
    ];


    public function orderdetail(){
        return $this->belongsToMany('App\Models\Orderdetail');
    }

    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
