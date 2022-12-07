<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productiontrx extends Model
{
    use HasFactory;

    protected $fillable =[
      'rawmaterial_id',
        'trx_no',
        'qty_collected',
        'qty_used',
        'qty_returned',
        'waste',
        'remarks',
        'date_of_trx',
        'ptn_no',
        'user_id',
    ];

    public function rawmaterial(){
        return $this->belongsTo(Rawmaterial::class, 'rawmaterial_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barcodes(){
        return $this->belongsTo(Barcode::class, 'barcode_id');
    }



}
