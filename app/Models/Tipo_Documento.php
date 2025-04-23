<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tipo_Documento extends Model
{
    use HasFactory;
    protected $table = 'tipos_documento';
    protected $primaryKey = 'id';
    public $timestamps=false;
    protected $fillable=['descripcion','estado'];
   
    public function clientes(){
       return $this -> hasMany(Cliente::class,'tipo_documento_id','id');
    }
}
