<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacaoServico extends Model
{
    protected $table = 'situacao_servicos';
    protected $primaryKey = 'sise_situacao_servico';
    protected $fillable = ['sise_descr_situacao_servico', 'sise_vigencia_situacao_servico'];
    protected $casts = ['sise_vigencia_situacao_servico' => 'date'];
}
