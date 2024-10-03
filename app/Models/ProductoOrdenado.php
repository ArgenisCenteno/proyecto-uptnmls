<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoOrdenado extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'cantidad',
        'producto_id',
        'solicitud_id',
    ];

    /**
     * Get the product associated with the ordered product.
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Get the request (solicitud) associated with the ordered product.
     */
    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }
}
