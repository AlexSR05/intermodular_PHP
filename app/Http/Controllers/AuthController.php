<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Auth;

class AuthController {


    public function showLoginForm(): void
    {
        view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        if (Auth::attempt($credentials)) {
            redirect(HOME)->send();
        }

        back()->with('message', 'Credenciales incorrectas')->send();
    }

    public function logout(){
        Auth::logout();
        redirect('/auth/show-login.php')->send();
    }

    /*
    public function register(): void
    {
        // Recoger datos de la petición
        $nombre = $_POST['nombre'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $role = $_POST['role'] ?? 'user'; // Valor por defecto

        // Validaciones básicas (puedes mejorar)
        if (!$nombre || !$email || !$password) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        // Comprobar que el email no exista
        if (Usuario::findByEmail($email)) {
            echo "El email ya está registrado.";
            return;
        }

        // Crear el nuevo usuario
        $usuario = new Usuario();
        $usuario->nombre = $nombre;
        $usuario->email = $email;
        $usuario->password = password_hash($password, PASSWORD_DEFAULT);
        $usuario->role = $role;
        $usuario->insert(); // Asumimos que `insert()` guarda en la base de datos y actualiza $usuario->id

        echo "Usuario registrado correctamente.";
    }
    */
}