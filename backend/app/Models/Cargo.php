<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargos';
    protected $primaryKey = 'carg_cod_cargo';
    protected $fillable = ['carg_descr_cargo', 'carg_dt_vigencia'];
    protected $casts = ['carg_dt_vigencia' => 'date'];
}
