<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $fillable = ['usuario_id', 'recurso_id', 'calendario_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function recurso()
    {
        return $this->belongsTo(Recurso::class);
    }

    public function calendario()
    {
        return $this->belongsTo(Calendario::class);
    }
}