<?php
require_once __DIR__ . '/../../bootstrap/bootstrap.php';

use App\Core\Auth;
use App\Models\Usuario;

if (!Auth::check() || Auth::user()['role'] !== 'admin') {
    redirect('/auth/login/index.php');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    session()->flash('error', 'ID de usuario no proporcionado');
    redirect('/usuarios/index.php');
}

$id = (int) $_GET['id'];

if ($id === Auth::id()) {
    session()->flash('error', 'No puedes eliminar tu propio usuario');
    redirect('/usuarios/index.php');
}

// Buscar el usuario
$usuario = Usuario::find($id);

if (!$usuario) {
    session()->flash('error', 'Usuario no encontrado');
    redirect('/usuarios/index.php');
}

// Eliminar el usuario
try {
    // Aquí podrías añadir lógica para eliminar datos relacionados con el usuario
    // Por ejemplo, valoraciones, compras, etc.
    
    $usuario->delete();
    session()->flash('success', 'Usuario eliminado correctamente');
} catch (\Exception $e) {
    session()->flash('error', 'Error al eliminar el usuario: ' . $e->getMessage());
}

redirect('/usuarios/index.php');
