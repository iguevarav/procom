<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
        protected $table = 'orden_compra';
    protected $fillable = ['numero_documento', 'empleado_id', 'proveedor_id', 'fecha_compra', 'motivo_compra', 'subtotal', 'estado'];
    protected $casts = [
    'fecha_compra' => 'date', 
    ];

    public function detalles()
    {
        return $this->hasMany(OrdenCompraDetalle::class, 'orden_compra_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
