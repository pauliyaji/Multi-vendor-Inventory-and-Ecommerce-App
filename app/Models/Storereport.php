<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storereport extends Model
{
    use HasFactory;

    protected $fillable =[
        'rawmaterial',
        'qty',
        're_order',
    ];

    public function rawmaterials(){
        return $this->belongsTo(Rawmaterial::class, 'rawmaterial');
    }


}
