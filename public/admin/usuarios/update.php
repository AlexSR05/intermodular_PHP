<?php
require_once __DIR__ . '/../../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../../app/Http/Controllers/AdminController.php';

use App\Http\Controllers\AdminController;
use App\Core\Request;
use App\Core\Auth;

if (!Auth::check() || Auth::role() !== 'admin') {
    session()->flash('error', 'No tienes permisos para acceder a esta página');
    header('Location: ' . BASE_URL . '/auth/login/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    session()->flash('error', 'Método no permitido');
    header('Location: ' . BASE_URL . '/admin/usuarios.php');
    exit;
}

$id = $_POST['id'] ?? $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    session()->flash('error', 'ID de usuario no válido');
    header('Location: ' . BASE_URL . '/admin/usuarios.php');
    exit;
}

$controller = new AdminController();
$controller->updateUsuario((int) $id, new Request());