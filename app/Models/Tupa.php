<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tupa extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'caja.tupa';
    protected $primaryKey = 'tupa_id';
}
