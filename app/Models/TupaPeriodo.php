<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TupaPeriodo extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'caja.tupa_periodo';
    protected $primaryKey = 'tupa_periodo_id';
}
