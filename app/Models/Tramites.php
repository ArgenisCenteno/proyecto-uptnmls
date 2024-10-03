<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramites extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'fecha',
        'tipo',
        'descripcion',
        'personal_id',
        'creado_por',
        'estado',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Relación con el modelo Personal
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
}
