<?php
require_once __DIR__ . '/../../bootstrap/bootstrap.php';

use App\Core\Auth;
use App\Models\Usuario;

// Verificar si el usuario está autenticado y es administrador
if (!Auth::check() || Auth::user()['role'] !== 'admin') {
    redirect('/auth/login/index.php');
}

// Obtener todos los usuarios
$usuarios = Usuario::all();

// Definir el contenido de la vista
$content = view('admin/usuarios/index', [
    'usuarios' => $usuarios
]);
