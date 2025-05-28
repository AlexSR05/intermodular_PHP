<?php
require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/UsuarioController.php';

use App\Core\Auth;
use App\Http\Controllers\UsuarioController;

// Verificar si el usuario está autenticado
if (!Auth::check()) {
    redirect('/auth/login/index.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/usuarios/profile.php');
}

$data = [
    'nombre' => $_POST['nombre'] ?? '',
    'password' => $_POST['password'] ?? '',
];

$usuarioController = new UsuarioController();
$result = $usuarioController->update($data);

if ($result) {
    $_SESSION['nombre'] = $data['nombre'];
    header('Location:edit.php');
} else {
    header('Location:edit.php');
}