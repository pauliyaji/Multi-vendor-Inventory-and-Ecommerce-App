<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'contact_person',
        'rawmaterial_id',

    ];

    public function rawmaterials(){
        return $this->belongsTo(Rawmaterial::class, 'rawmaterial_id');
    }
}
