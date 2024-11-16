<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'seguridad.usuario';
    protected $primaryKey = 'usuario_id';
}
