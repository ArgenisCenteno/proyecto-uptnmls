<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activa',
    ];

    public function aperturasCaja()
    {
        return $this->hasMany(AperturaCaja::class);
    }

    public function cierresCaja()
    {
        return $this->hasMany(CierreCaja::class);
    }
}
