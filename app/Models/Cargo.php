<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargos';
    protected $fillable = [
        'descripcion',
        'estado',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_cargo', 'id');
    }   

}
