<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Producto extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida',
        'cantidad',
        'sub_categoria_id',
        'disponible',
        'tipo'
    ];
    public function subCategoria()
    {
        return $this->belongsTo(SubCategoria::class, 'sub_categoria_id');
    }
   
}
