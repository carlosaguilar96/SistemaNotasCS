<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AñoEscolar extends Model
{
    use HasFactory;
    protected $table = 'añoescolar';
    protected $primaryKey = 'idAño';
    public $timestamps = false;
}
