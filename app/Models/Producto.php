<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre','descripcion','id_categoria','id_marca','costo','precio','stock','id_unidad','estado'
    ];

    public function categoria(){
        return $this -> hasOne(Categoria::class,'id','id_categoria');
    }

    public function marca(){
        return $this -> hasOne(Marca::class,'id','id_marca');
    }

    public function unidad(){
        return $this -> hasOne(Unidad::class,'id','id_unidad');
    }

    public function detalleOrdenCompras()
    {
        return $this->hasMany(Detalle_Orden_Compra::class, 'orden_compra_id', 'id');
    }
}
