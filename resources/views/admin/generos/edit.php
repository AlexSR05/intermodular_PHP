<?php
require_once __DIR__ . '/../../../bootstrap/bootstrap.php';

use App\Core\Auth;
use App\Core\Request;
use App\Models\Genero;

// Verificar si el usuario está autenticado y es administrador
if (!Auth::check() || Auth::user()['role'] !== 'admin') {
    redirect('/auth/login/index.php');
}

// Obtener el ID del género
$id = $_GET['id'] ?? null;
if (!$id) {
    redirect('/admin/generos.php');
}

// Buscar el género
$genero = Genero::find($id);
if (!$genero) {
    $_SESSION['error'] = 'Género no encontrado';
    redirect('/admin/generos.php');
}

// Renderizar la vista
view('admin/generos/edit', compact('genero'));
?>