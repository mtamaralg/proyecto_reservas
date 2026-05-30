<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramoHorario extends Model
{
    use HasFactory;

    protected $table = 'tramos_horarios';
    protected $fillable = ['dia_semana', 'hora_inicio', 'hora_fin'];

    public function calendarios()
    {
        return $this->hasMany(Calendario::class);
    }
}