<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    use HasFactory;

    protected $table = 'calendarios';
    protected $fillable = ['fecha', 'tramos_horarios_id'];

    public function tramoHorario()
    {
        // Un calendario pertenece a un tramo horario
        return $this->belongsTo(TramoHorario::class, 'tramos_horarios_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}