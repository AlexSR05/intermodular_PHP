<?php
require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . "/../../app/Http/Controllers/UsuarioController.php";

use App\Core\Auth;
use App\Http\Controllers\UsuarioController;

if (!Auth::check()) {
    redirect('/auth/login/index.php');
}

$usuarioController = new UsuarioController();
$usuario = $usuarioController->getCurrentUser();

$styles = ['/css/profile.css'];

view('usuarios/edit', [
    'usuario' => $usuario,
    'header' => 'index',
    'styles' => $styles,
    'title' => 'Editar Perfil - LoopLab'
]);
