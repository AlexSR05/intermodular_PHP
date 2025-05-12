<?php
require_once __DIR__ . '/../bootstrap/bootstrap.php';

use App\Models\Usuario;


$nombre = 'Usuario';
$email = 'usuario@example.com';
$password = '123456';
$role = 'user';


/*
$nombre = 'Administrador';
$email = 'administrador@example.com';
$password = '123456';
$role = 'admin';
*/


// Comprobar que el email no exista
if (Usuario::where('email', $email)->first()) {
    echo "El email ya está registrado.";
    return;
}

$usuario = new Usuario();
$usuario->nombre = $nombre;
$usuario->email = $email;
$usuario->password = password_hash($password, PASSWORD_DEFAULT);
$usuario->role = $role;
$usuario->save();

echo "Usuario registrado correctamente.";

