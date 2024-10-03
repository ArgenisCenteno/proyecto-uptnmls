<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'proveedor_id',
        'user_id',
        'monto_total',
        'status',
        'porcentaje_descuento',
        'pago_id'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'id_compra');
    }
}
