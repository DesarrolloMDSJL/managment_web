<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoTupa extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'caja.pago_tupa';
    protected $primaryKey = 'pago_tupa_id';
}
