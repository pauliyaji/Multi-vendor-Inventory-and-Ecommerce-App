<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productinventoryreport extends Model
{
    use HasFactory;

    protected $fillable =[
        'product_id',
        'total_qty',
        'total_cost_price',
        'total_selling_price',
    ];
}
