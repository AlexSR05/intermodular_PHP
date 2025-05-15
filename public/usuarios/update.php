<?php
require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . "/../../app/Http/Controllers/UsuarioController.php";

use App\Core\Auth;
use App\Http\Controllers\UsuarioController;

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
    Auth::check(['nombre' => $data['nombre']]);
    session()->flash('success', 'Perfil actualizado correctamente');
    redirect('/usuarios/profile.php');
} else {
    session()->flash('error', 'No se pudo actualizar el perfil');
}
