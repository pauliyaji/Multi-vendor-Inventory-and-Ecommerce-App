<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storereport extends Model
{
    use HasFactory;

    protected $fillable =[
        'rawmaterial',
        'total_qty',
        'qty',
        'total_price',
        're_order',
    ];

    public function rawmaterials(){
        return $this->belongsTo(Rawmaterial::class, 'rawmaterial');
    }


}
