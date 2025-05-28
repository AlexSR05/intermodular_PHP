<?php
require_once __DIR__ . '/../../../bootstrap/bootstrap.php';

use App\Core\Auth;
use App\Core\Request;
use App\Models\Genero;
use App\Models\Instrumental;

// Verificar si el usuario está autenticado y es administrador
if (!Auth::check() || Auth::user()['role'] !== 'admin') {
    redirect('/auth/login/index.php');
}

// Verificar si es una solicitud POST
$request = new Request();
if ($request->method() !== 'POST') {
    redirect('/admin/generos.php');
}

// Obtener el ID del género
$id = isset($_POST['id']) ? $_POST['id'] : null;
if (!$id) {
    redirect('/admin/generos.php');
}

// Buscar el género
$genero = Genero::find($id);
if (!$genero) {
    $_SESSION['error'] = 'Género no encontrado';
    redirect('/admin/generos.php');
}

// Verificar si hay instrumentales asociados a este género
$instrumentalesCount = Instrumental::where('genero_id', $id)->count();
if ($instrumentalesCount > 0) {
    $_SESSION['error'] = 'No se puede eliminar el género porque tiene instrumentales asociados';
    redirect('/admin/generos.php');
}

// Eliminar el género
$genero->delete();

// Redirigir con mensaje de éxito
$_SESSION['success'] = 'Género eliminado correctamente';
redirect('/admin/generos.php');
?>
