<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escolaridade extends Model
{
    protected $table = 'escolaridades';
    protected $primaryKey = 'esco_cod_escolaridade';
    protected $fillable = ['esco_descr_escolaridade'];
}
