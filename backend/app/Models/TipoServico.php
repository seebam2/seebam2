<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServico extends Model
{
    protected $table = 'tipo_servicos';
    protected $primaryKey = 'tser_tipo_servico';
    protected $fillable = ['tser_descr_tipo_servico', 'tser_vigencia_tipo_servico'];
    protected $casts = ['tser_vigencia_tipo_servico' => 'date'];
}
