<?php
require_once __DIR__ . '/../../../bootstrap/bootstrap.php';

use App\Core\Auth;

if (!Auth::check() || Auth::user()['role'] !== 'admin') {
    redirect('/auth/login/index.php');
}

view('admin/generos/create');
?>