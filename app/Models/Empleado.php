<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $primaryKey = 'id';
    public $timestamps=false;
    protected $fillable = [
        'nombre',
        'tipo_documento_id',
        'cargo_id',
        'numero_documento',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'salario',
        'estado'
    ];

    public function tipo_documento()
    {
        return $this->belongsTo(Tipo_Documento::class, 'tipo_documento_id');
    }   

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }   

    public function ordenCompra(){
        return $this->hasMany(Orden_Compra::class, 'empleado_id', 'id');
    }

    
}
