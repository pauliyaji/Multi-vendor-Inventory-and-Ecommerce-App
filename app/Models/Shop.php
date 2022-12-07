<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_no',
        'user_id',
        'phone',
        'date_of_engagement',
        'coverage_area',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statuses(){
        return $this->belongsTo(Shopstatus::class, 'status');
    }
}
