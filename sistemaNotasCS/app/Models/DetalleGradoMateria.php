<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGradoMateria extends Model
{
    use HasFactory;

    protected $table = 'detallegradomateria';
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
