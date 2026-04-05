<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    protected $table = 'estados';
    protected $primaryKey = 'esta_cod_estado';
    protected $fillable = ['esta_descr_estado', 'esta_sigla'];

    public function municipios(): HasMany { return $this->hasMany(Municipio::class, 'esta_cod_estado', 'esta_cod_estado'); }
}
