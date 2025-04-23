<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tipo_Documento;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'nombre',
        'tipo_documento_id',
        'numero_documento',
        'email',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'estado'
    ];

    public function tipo_documento()
    {
        return $this->belongsTo(Tipo_Documento::class, 'tipo_documento_id');
    }   
}
