<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSeccionEstudiante extends Model
{
    use HasFactory;
    protected $table = 'detalleseccionestudiante';
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
