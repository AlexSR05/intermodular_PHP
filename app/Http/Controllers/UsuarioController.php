<?php

namespace App\Http\Controllers;

use App\Core\Auth;
use App\Models\Usuario;
use App\Models\Valoracion;

class UsuarioController
{
    public function getCurrentUser()
    {
        $userId = Auth::id();
        return Usuario::find($userId);
    }

    public function getUserValorations()
    {
        $userId = Auth::id();
        return Valoracion::where('id_usuario', $userId)->get();
    }

    public function update($data)
    {
        $userId = Auth::id();
        $usuario = Usuario::find($userId);

        if (!$usuario) {
            return false;
        }

        // Actualizar solo los campos permitidos
        if (isset($data['nombre']) && !empty($data['nombre'])) {
            $usuario->nombre = $data['nombre'];
        }

        // Actualizar contraseña si se proporciona
        if (isset($data['password']) && !empty($data['password'])) {
            $usuario->password = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Guardar cambios
        return $usuario->save();
    }
}
