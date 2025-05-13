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
            redirect('/instrumentales/index.php')->with('success','Bienvenido!')->send();
        }

        back()->with('message', 'Credenciales incorrectas')->send();
    }

    public function logout(){
        Auth::logout();
        redirect('/auth/login/index.php')->send();
    }

    public function register(Request $request): void
    {
        // Recoger datos de la petición
        $nombre = $request->nombre;
        $email = $request->email;
        $password = $request->password;
        $role = 'user';

        // Comprobar que el email no exista
        /*if (Usuario::findByEmail($email)) {
            back()->with('error', 'El email ya está registrado')->withInput(['email' => $email])->send();
        }*/

        // Crear el nuevo usuario
        $usuario = new Usuario();
        $usuario->nombre = $nombre;
        $usuario->email = $email;
        $usuario->password = password_hash($password, PASSWORD_DEFAULT);
        $usuario->role = $role;
        $usuario->save(); // Asumimos que `insert()` guarda en la base de datos y actualiza $usuario->id

        redirect('/instrumentales/index.php')->with('success','Registro realizado con éxito.');
    }
}