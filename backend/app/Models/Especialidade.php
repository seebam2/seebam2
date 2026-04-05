<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    protected $table = 'especialidades';
    protected $primaryKey = 'espe_cod_especialidade';
    protected $fillable = ['espe_descr_especialidade', 'espe_dt_vigencia'];
    protected $casts = ['espe_dt_vigencia' => 'date'];
}
