<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storetrx extends Model
{
    use HasFactory;

    protected $fillable = [
      'rawmaterial_id',
        'qty',
        'unit_price',
        'total_price',
        'date_of_trx',
        'trx_no',
        'barcode_id',
        'trxtype_id',
        'approvalstatus_id',
        'remarks',
    ];

    public function rawmaterials(){
        return $this->belongsTo(Rawmaterial::class, 'rawmaterial_id');
    }

    public function barcodes(){
        return $this->belongsTo(Barcode::class, 'barcode_id');
    }

    public function trxtypes(){
        return $this->belongsTo(Trxtype::class, 'trxtype_id');
    }

    public function approvalstatuses(){
        return $this->belongsTo(Approvalstatus::class, 'approvalstatus_id');
    }
}
