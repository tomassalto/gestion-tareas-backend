<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserStandard extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, HasRoles;

    // Nombre de la tabla
    protected $table = 'user_standard';
    protected $guard_name = 'web';
    protected $primaryKey = 'dni';
    public $incrementing = false;

    // Campos asignables en masa
    protected $fillable = [
        'dni',
        'email',
        'password',
    ];



    // Ocultar ciertos campos al serializar el modelo
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(\Spatie\Permission\Models\Role::class, 'model_has_roles', 'model_id', 'role_id');
    }
}
