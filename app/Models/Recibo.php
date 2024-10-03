<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'monto',
        'estatus',
        'pago_id',
        'user_id',
        'observaciones',
        'activo',
        'creado_id',
        'descuento'
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
