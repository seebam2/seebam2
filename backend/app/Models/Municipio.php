<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $primaryKey = 'muni_cod_municipio';
    protected $fillable = ['esta_cod_estado', 'muni_descr_municipio'];

    public function estado(): BelongsTo { return $this->belongsTo(Estado::class, 'esta_cod_estado', 'esta_cod_estado'); }
}
