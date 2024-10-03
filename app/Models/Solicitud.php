<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solicitud extends Model
{
    protected $table = 'solicitud'; 
    use HasFactory;
 
    
    protected $fillable = [
        'fecha',
        'descripcion',
        'financiamiento',
        'proveedor_id',
        'creado_por', // Asegúrate de que este campo sea asignable
    ];

    /**
     * Get the user that created the solicitud.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    /**
     * Get the proveedor associated with the solicitud.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}