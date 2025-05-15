<?php
require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . "/../../app/Http/Controllers/UsuarioController.php";


use App\Core\Auth;
use App\Http\Controllers\UsuarioController;

// Verificar si el usuario está autenticado
if (!Auth::check()) {
    redirect('/auth/login/index.php');
}

// Obtener el usuario actual
$usuarioController = new UsuarioController();
$usuario = $usuarioController->getCurrentUser();
$valoraciones = $usuarioController->getUserValorations();

// Incluir el CSS directamente
$styles = ['/css/profile.css'];

// Renderizar la vista
view('usuarios/profile', [
    'usuario' => $usuario,
    'valoraciones' => $valoraciones,
    'header' => 'index',
    'styles' => $styles,
    'title' => 'Mi Perfil - LoopLab'
]);
