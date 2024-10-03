<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'status',
        'banco_origen',
        'banco_destino',
        'numero_referencia',
        'fecha_pago',
        'monto_total',
        'monto_neto',
        'descuento',
        'tasa_dolar',
        'forma_pago',
        'comprobante_archivo',
        'creado_id',
        'porcentaje_descuento',
        'impuestos'
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'pago_id');
    }

    public function recibos()
    {
        return $this->hasMany(Recibo::class, 'pago_id');
    }
}
