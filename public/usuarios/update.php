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
    redirect('../resources/views/usuarios/profile.php');
    // Actualizar la sesión con el nuevo nombre
    // Update session with new name
    $_SESSION['nombre'] = $data['nombre'];
    // Set flash message for success
    $_SESSION['success'] = 'Perfil actualizado correctamente';
} else {
    // Set flash message for error
    $_SESSION['flash_error'] = 'No se pudo actualizar el perfil';
}
