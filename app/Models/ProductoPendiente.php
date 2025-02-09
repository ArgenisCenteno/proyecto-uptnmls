<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoPendiente extends Model
{
    use HasFactory;

    protected $table = 'producto_pendientes';

    protected $fillable = [
        'producto_asignado_id',
        'cantidad',
        'fecha_entrega',
        'observaciones',
        'tramite_id',
    ];

    public function productoAsignado()
    {
        return $this->belongsTo(ProductoAsignado::class, 'producto_asignado_id');
    }
    public function tramite()
    {
        return $this->belongsTo(Tramites::class, 'tramite_id');
    }

}
