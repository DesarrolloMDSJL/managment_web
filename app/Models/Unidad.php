<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'mante.unidad';
    protected $primaryKey = 'unidad_id';
}
