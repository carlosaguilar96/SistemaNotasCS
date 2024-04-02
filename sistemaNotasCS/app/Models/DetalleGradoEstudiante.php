<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGradoEstudiante extends Model
{
    use HasFactory;
    
    protected $table = 'detallegradoestudiante';
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
