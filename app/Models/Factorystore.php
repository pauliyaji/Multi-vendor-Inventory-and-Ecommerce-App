<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factorystore extends Model
{
    use HasFactory;

    protected $fillable = [
        'rawmaterial_id',
        'supplier_id',
        'qty',
        'unit_price',
        'total_price',
        'paymentstatus_id',
        'date_of_supply',
        'paymentmethod_id',
        'amount_paid',
        'balance',
        'user_id',
        'remarks',
        'units_id',
    ];


    public function units(){
        return $this->belongsTo(Unitofmeasure::class, 'units_id');
    }

    public function rawmaterial(){
        return $this->belongsTo(Rawmaterial::class, 'rawmaterial_id');
    }

    public function paymentstatus(){
        return $this->belongsTo(Paymentstatus::class, 'paymentstatus_id');
    }

    public function paymentmethod(){
        return $this->belongsTo(Paymentmethod::class, 'paymentmethod_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function suppliers(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
