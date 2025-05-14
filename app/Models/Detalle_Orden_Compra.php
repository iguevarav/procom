<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_Orden_Compra extends Model
{
    protected $table = 'detalle_orden_compras';

    protected $primaryKey = 'id';
    public $timestamps=false;

    protected $fillable = [
        'orden_compra_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal_item'
    ];

    public function ordenCompra()
    {
        return $this->belongsTo(Orden_Compra::class, 'orden_compra_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
