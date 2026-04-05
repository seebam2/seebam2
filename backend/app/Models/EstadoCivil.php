<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $table = 'estados_civis';
    protected $primaryKey = 'esci_cod_estado_civil';
    protected $fillable = ['esci_descr_estado_civil'];
}
