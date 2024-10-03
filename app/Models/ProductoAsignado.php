<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoAsignado extends Model
{
    use HasFactory;
    protected $table = 'productos_asignados';

    protected $fillable = [
        'fecha',
        'cantidad',
        'producto_id',
        'asignacion_id',
    ];

    /**
     * Get the product associated with the assigned product.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Get the assignment associated with the assigned product.
     */
    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class, 'asignacion_id');
    }
}
