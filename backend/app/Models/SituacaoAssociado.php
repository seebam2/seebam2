<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacaoAssociado extends Model
{
    protected $table = 'situacao_associado';
    protected $primaryKey = 'sias_cod_situacao_associado';
    protected $fillable = ['sias_descr_situacao_associado', 'sias_dt_vigencia'];
    protected $casts = ['sias_dt_vigencia' => 'date'];
}
