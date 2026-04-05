<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    protected $table = 'parentescos';
    protected $primaryKey = 'pare_cod_parentesco';
    protected $fillable = ['pare_descricao_parentesco'];
}
