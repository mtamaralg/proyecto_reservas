<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    
    protected $table = 'categorias'; // Le decimos el nombre exacto de la tabla
    protected $fillable = ['nombre', 'descripcion'];

    public function recursos()
    {
        return $this->hasMany(Recurso::class);
    }
}