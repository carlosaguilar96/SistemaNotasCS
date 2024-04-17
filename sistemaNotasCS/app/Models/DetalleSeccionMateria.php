<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSeccionMateria extends Model
{
    use HasFactory;
    protected $table = 'detalleseccionmateria';
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
