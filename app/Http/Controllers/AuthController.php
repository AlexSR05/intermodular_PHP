<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Models\Usuario;

class AuthController {

    public function showLoginForm(): void
    {
        view('auth.login');
    }

    public function showRegisterForm(): void
    {
        view('auth.register');
    }
    
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        if (Auth::attempt($credentials)) {
            // Debug information to verify session is set
            if (defined('DEBUG') && DEBUG) {
                echo "<pre>Session after login: ";
                print_r(session()->get('user'));
                echo "</pre>";
                exit;
            }
            
            // Direct header redirection instead of using the redirect helper
            header('Location: ' . BASE_URL . '/instrumentales/index.php');
            exit;
        }

        // If credentials are incorrect
        session()->flash('error', 'Credenciales incorrectas');
        header('Location: ' . BASE_URL . '/auth/login/index.php');
        exit;
    }

    public function logout(){
        Auth::logout();
        header('Location: ' . BASE_URL . '/auth/login/index.php');
        exit;
    }

    public function register(Request $request): void
    {
        // Recoger datos de la petición
        $nombre = $request->nombre;
        $email = $request->email;
        $password = $request->password;
        $role = 'user';

        // Comprobar que el email no exista
        if (Usuario::where('email', $email)->first()) {
            session()->flash('error', 'El email ya está registrado');
            session()->flash('old', ['nombre' => $nombre, 'email' => $email]);
            header('Location: ' . BASE_URL . '/auth/register/index.php');
            exit;
        }

        // Crear el nuevo usuario
        $usuario = new Usuario();
        $usuario->nombre = $nombre;
        $usuario->email = $email;
        $usuario->password = password_hash($password, PASSWORD_DEFAULT);
        $usuario->role = $role;
        $usuario->save();

        // Iniciar sesión automáticamente
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            header('Location: ' . BASE_URL . '/instrumentales/index.php');
        } else {
            // If auto-login fails, redirect to login page
            session()->flash('success', 'Registro exitoso. Por favor inicia sesión.');
            header('Location: ' . BASE_URL . '/auth/login/index.php');
        }
        exit;
    }
}
