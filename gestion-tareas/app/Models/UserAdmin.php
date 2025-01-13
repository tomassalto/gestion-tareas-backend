<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'user_admin';

    // Campos asignables en masa
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Ocultar ciertos campos al serializar el modelo
    protected $hidden = [
        'password',
    ];
}
