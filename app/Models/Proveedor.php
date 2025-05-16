<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tipo_Proveedor;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $primaryKey = 'id';
    public $timestamps=false;
    protected $fillable=['razon_social','ruc','telefono', 'email', 'tipo_proveedor_id','direccion','estado'];
   
    public function tipo_proveedor()
    {
        return $this->belongsTo(Tipo_Proveedor::class, 'tipo_proveedor_id');
    } 

    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class, 'proveedor_id');
    }

}
