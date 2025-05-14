<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Tipo_Proveedor extends Model
{
    use HasFactory;
    protected $table = 'tipos_proveedor';
    protected $primaryKey = 'id';
    public $timestamps=false;
    protected $fillable=['descripcion','estado'];
   
    public function proveedores(){
       return $this -> hasMany(Cliente::class,'tipo_proveedor_id','id');
    }
}
