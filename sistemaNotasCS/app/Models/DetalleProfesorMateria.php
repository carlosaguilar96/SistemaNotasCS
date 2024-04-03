<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProfesorMateria extends Model
{
    use HasFactory;

    protected $table = 'detalleprofesormateria';
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
