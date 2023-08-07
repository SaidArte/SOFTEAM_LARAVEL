<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'PERSONAS';

    // Nombre de la clave primaria en la tabla
    protected $primaryKey = 'COD_PERSONA';

    // Columnas que se pueden rellenar masivamente (si las tienes)
    protected $fillable = [
        'NOM_PERSONA',
        // Otras columnas si las tienes...
    ];

    // Otras configuraciones si las necesitas...

    // Relación con los Fierros (si tienes una relación definida en la tabla)
    public function fierros()
    {
        return $this->hasMany(Fierro::class, 'COD_PERSONA', 'COD_PERSONA');
    }
}