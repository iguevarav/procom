<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden_Compra extends Model
{
    protected $table = 'orden_compras';

    protected $primaryKey = 'id';
    public $timestamps=false;

    protected $fillable = [
        'empleado_id',
        'proveedor_id',
        'numero_documento',
        'fecha_compra',
        'motivo_compra',
        'subtotal',
        'estado'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function detalleOrdenCompras()
    {
        return $this->hasMany(Detalle_Orden_Compra::class, 'orden_compra_id', 'id');
    }
public function detalle_orden_compras()
{
    return $this->hasMany(Detalle_Orden_Compra::class, 'orden_compra_id');
}

    
}
