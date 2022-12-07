<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rawmaterial extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
        'unit_price',
      'unit_of_measure_id',
        're_order',

    ];

    public function units(){
        return $this->belongsTo(Unitofmeasure::class, 'unit_of_measure_id');
    }
}
