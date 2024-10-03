<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaCaja extends Model
{
    use HasFactory;
    protected $table = 'aperturas_caja'; 
 
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'id',
        'caja_id',
        'usuario_id',
        'monto_inicial_bolivares',
        'monto_inicial_dolares',
        'apertura',
    ];
}
