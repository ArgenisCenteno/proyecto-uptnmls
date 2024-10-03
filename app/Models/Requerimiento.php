<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requerimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'descripcion',
        'uso',
        'creado_por', // Asegúrate de que este campo sea asignable
        'status'
    ];

    /**
     * Get the user that created the requerimiento.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
