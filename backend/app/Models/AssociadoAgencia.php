<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssociadoAgencia extends Model
{
    protected $table = 'associado_agencia';
    protected $primaryKey = 'asag_id_associado_agencia';
    protected $fillable = ['asso_inscricao_associado', 'agnc_cod_agencia', 'asag_matricula', 'carg_cod_cargo', 'asag_dt_admissao', 'asag_dt_demissao', 'sias_cod_situacao_associado', 'asag_comentario'];
    protected $casts = ['asag_dt_admissao' => 'datetime', 'asag_dt_demissao' => 'datetime'];

    public function associado(): BelongsTo { return $this->belongsTo(Associado::class, 'asso_inscricao_associado', 'asso_inscricao_associado'); }
    public function agencia(): BelongsTo { return $this->belongsTo(Agencia::class, 'agnc_cod_agencia', 'agnc_cod_agencia'); }
    public function cargo(): BelongsTo { return $this->belongsTo(Cargo::class, 'carg_cod_cargo', 'carg_cod_cargo'); }
    public function situacao(): BelongsTo { return $this->belongsTo(SituacaoAssociado::class, 'sias_cod_situacao_associado', 'sias_cod_situacao_associado'); }
}
