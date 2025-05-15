<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Valoracion;
use App\Core\Auth;
use App\Core\DB;

class ValoracionController
{
    public function getAll(): array
    {
        // Obtener todas las valoraciones ordenadas por fecha más reciente
        return Valoracion::orderBy('fecha_valoracion', 'DESC')->get();
    }
    
    public function store(): void
    {
        if (!Auth::check()) {
            session()->flash('error', 'Debes iniciar sesión para enviar una valoración.');
            header('Location: ' . BASE_URL);
            exit;
        }
        
        $comentario = $_POST['comentario'] ?? '';
        $puntuacion = (int)($_POST['puntuacion'] ?? 0);
        
        if (empty($comentario) || $puntuacion < 1 || $puntuacion > 5) {
            session()->flash('error', 'Por favor, completa todos los campos correctamente.');
            header('Location: ' . BASE_URL);
            exit;
        }
        
        $valoracion = new Valoracion();
        $valoracion->comentario = $comentario;
        $valoracion->num_valoracion = $puntuacion;
        $user = Auth::user();
        $valoracion->id_usuario = is_object($user) ? $user->id : null;
        
        try {
            $valoracion->insert();
            session()->flash('success', '¡Gracias por tu valoración!');
        } catch (\Exception $e) {
            session()->flash('error', 'Ha ocurrido un error al guardar tu valoración. Por favor, inténtalo de nuevo.');
        }
        
        header('Location: ' . BASE_URL);
        exit;
    }
}
