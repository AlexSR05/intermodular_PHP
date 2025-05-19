<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Auth;
use App\Models\Usuario;
use App\Models\Instrumental;
use App\Models\Productor;
use App\Models\Genero;
use App\Models\Valoracion;
use App\Core\DB;
use App\Core\Request;

class AdminController
{
    /**
     * Constructor - Verifica que el usuario sea administrador
     */
    public function __construct()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            session()->flash('error', 'Debes iniciar sesión para acceder al panel de administración');
            header('Location: ' . BASE_URL . '/auth/login/index.php');
            exit;
        }
        
        // Verificar si el usuario es administrador
        if (Auth::role() !== 'admin') {
            session()->flash('error', 'No tienes permisos para acceder al panel de administración');
            header('Location: ' . BASE_URL . '/instrumentales/index.php');
            exit;
        }
    }
    
    /**
     * Muestra el dashboard principal
     */
    public function index()
    {
        $totalInstrumentales = count(Instrumental::all());
        $totalUsuarios = count(Usuario::all());
        $totalValoraciones = count(Valoracion::all());
        $totalProductores = count(Productor::all());
        
        // Obtener datos para el dashboard completo
        $instrumentalesRecientes = Instrumental::orderBy('fecha_creacion', 'DESC')->limit(5)->get();
        $usuariosRecientes = Usuario::orderBy('fecha_creacion', 'DESC')->limit(5)->get();
        $valoracionesRecientes = Valoracion::orderBy('fecha_valoracion', 'DESC')->limit(5)->get();
        $productores = Productor::all();
        
        // Estadísticas de géneros
        $generosStats = $this->getGenerosStats();
        
        // Estadísticas de valoraciones
        $valoracionesStats = $this->getValoracionesStats();
        
        // Conteo de instrumentales por productor
        $productorInstrumentales = $this->getProductorInstrumentales();
        
        view('admin.dashboard', [
            'totalInstrumentales' => $totalInstrumentales,
            'totalUsuarios' => $totalUsuarios,
            'totalValoraciones' => $totalValoraciones,
            'totalProductores' => $totalProductores,
            'instrumentalesRecientes' => $instrumentalesRecientes,
            'usuariosRecientes' => $usuariosRecientes,
            'valoracionesRecientes' => $valoracionesRecientes,
            'productores' => $productores,
            'generosStats' => $generosStats,
            'valoracionesStats' => $valoracionesStats,
            'productorInstrumentales' => $productorInstrumentales,
            'title' => 'Dashboard Completo - LoopLab'
        ]);
    }
    
    /**
     * Obtiene estadísticas de géneros para el gráfico
     */
    private function getGenerosStats(): array
    {
        $generos = Genero::all();
        $stats = [];
        
        foreach ($generos as $genero) {
            // Contar instrumentales por género
            $sql = "SELECT COUNT(*) as count FROM pertenecer WHERE id_genero = ?";
            $result = DB::selectAssoc($sql, [$genero->id]);
            
            $stats[] = [
                'id' => $genero->id,
                'nombre' => $genero->nombre,
                'count' => (int)$result[0]['count']
            ];
        }
        
        return $stats;
    }
    
    /**
     * Obtiene estadísticas de valoraciones para el gráfico
     */
    private function getValoracionesStats(): array
    {
        $stats = [0, 0, 0, 0, 0]; // Inicializar contadores para 5, 4, 3, 2, 1 estrellas
        
        $valoraciones = Valoracion::all();
        
        foreach ($valoraciones as $valoracion) {
            if ($valoracion->num_valoracion >= 1 && $valoracion->num_valoracion <= 5) {
                $stats[5 - $valoracion->num_valoracion]++;
            }
        }
        
        return $stats;
    }
    
    /**
     * Obtiene el conteo de instrumentales por productor
     */
    private function getProductorInstrumentales(): array
    {
        $productores = Productor::all();
        $stats = [];
        
        foreach ($productores as $productor) {
            $sql = "SELECT COUNT(*) as count FROM instrumentales WHERE id_productor = ?";
            $result = DB::selectAssoc($sql, [$productor->id]);
            
            $stats[$productor->id] = (int)$result[0]['count'];
        }
        
        return $stats;
    }
    
    /**
     * Muestra el dashboard completo
     */
    public function dashboard()
    {
        $this->index(); // Reutilizamos el método index para el dashboard completo
    }
    
    /**
     * Gestión de instrumentales
     */
    public function instrumentales()
    {
        $instrumentales = Instrumental::orderBy('fecha_creacion', 'DESC')->get();
        
        view('admin.instrumentales.index', [
            'instrumentales' => $instrumentales,
            'title' => 'Gestión de Instrumentales - LoopLab'
        ]);
    }
    
    /**
     * Formulario para crear un nuevo instrumental
     */
    public function createInstrumental()
    {
        $productores = Productor::all();
        $generos = Genero::all();
        
        view('admin.instrumentales.create', [
            'productores' => $productores,
            'generos' => $generos,
            'title' => 'Crear Instrumental - LoopLab'
        ]);
    }
    
    /**
     * Guarda un nuevo instrumental
     */
    public function storeInstrumental(Request $request)
    {
        // Validar datos
        if (empty($request->titulo) || empty($request->precio) || empty($request->id_productor)) {
            session()->flash('error', 'Todos los campos son obligatorios');
            header('Location: ' . BASE_URL . '/instrumentales/create.php');
            exit;
        }
        
        // Procesar imagen si se ha subido
        $imagen = 'uploads/default.jpg'; // Imagen por defecto
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/';
            $fileName = uniqid() . '_' . basename($_FILES['imagen']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                $imagen = 'uploads/' . $fileName;
            }
        }
        
        // Procesar audio si se ha subido
        $audio = null;
        if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/audiouploads/';
            $fileName = uniqid() . '_' . basename($_FILES['audio']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['audio']['tmp_name'], $uploadFile)) {
                $audio = 'audiouploads/' . $fileName;
            }
        }
        
        // Crear el instrumental
        $instrumental = new Instrumental();
        $instrumental->titulo = $request->titulo;
        $instrumental->bpm = $request->bpm ?? 0;
        $instrumental->precio = $request->precio;
        $instrumental->id_productor = $request->id_productor;
        $instrumental->imagen = $imagen;
        $instrumental->audio = $audio;
        $instrumental->insert();
        
        // Asociar géneros
        if (!empty($request->generos)) {
            foreach ($request->generos as $genero_id) {
                DB::insert("INSERT INTO pertenecer (id_instrumental, id_genero) VALUES (?, ?)", [$instrumental->id, $genero_id]);
            }
        }
        
        session()->flash('success', 'Instrumental creado correctamente');
        header('Location: ' . BASE_URL . '/instrumentales/index.php');
        exit;
    }
    
    /**
     * Formulario para editar un instrumental
     */
    public function editInstrumental($id)
    {
        $instrumental = Instrumental::find($id);
        if (!$instrumental) {
            session()->flash('error', 'Instrumental no encontrado');
            header('Location: ' . BASE_URL . '/instrumentales/index.php');
            exit;
        }
        
        $productores = Productor::all();
        $generos = Genero::all();
        
        // Obtener los géneros asociados al instrumental
        $sql = "SELECT id_genero FROM pertenecer WHERE id_instrumental = ?";
        $result = DB::selectAssoc($sql, [$id]);
        $instrumentalGeneros = array_column($result, 'id_genero');
        
        view('admin.instrumentales.edit', [
            'instrumental' => $instrumental,
            'productores' => $productores,
            'generos' => $generos,
            'instrumentalGeneros' => $instrumentalGeneros,
            'title' => 'Editar Instrumental - LoopLab'
        ]);
    }
    
    /**
     * Actualiza un instrumental
     */
    public function updateInstrumental($id, Request $request)
    {
        $instrumental = Instrumental::find($id);
        if (!$instrumental) {
            session()->flash('error', 'Instrumental no encontrado');
            header('Location: ' . BASE_URL . '/instrumentales/index.php');
            exit;
        }
        
        // Validar datos
        if (empty($request->titulo) || empty($request->precio) || empty($request->id_productor)) {
            session()->flash('error', 'Todos los campos son obligatorios');
            header('Location: ' . BASE_URL . '/instrumentales/edit.php?id=' . $id);
            exit;
        }
        
        // Procesar imagen si se ha subido
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/';
            $fileName = uniqid() . '_' . basename($_FILES['imagen']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                $instrumental->imagen = 'uploads/' . $fileName;
            }
        }
        
        // Procesar audio si se ha subido
        if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/audiouploads/';
            $fileName = uniqid() . '_' . basename($_FILES['audio']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['audio']['tmp_name'], $uploadFile)) {
                $instrumental->audio = 'audiouploads/' . $fileName;
            }
        }
        
        // Actualizar el instrumental
        $instrumental->titulo = $request->titulo;
        $instrumental->bpm = $request->bpm ?? 0;
        $instrumental->precio = $request->precio;
        $instrumental->id_productor = $request->id_productor;
        $instrumental->update();
        
        // Actualizar géneros
        DB::delete("DELETE FROM pertenecer WHERE id_instrumental = ?", [$id]);
        if (!empty($request->generos)) {
            foreach ($request->generos as $genero_id) {
                DB::insert("INSERT INTO pertenecer (id_instrumental, id_genero) VALUES (?, ?)", [$id, $genero_id]);
            }
        }
        
        session()->flash('success', 'Instrumental actualizado correctamente');
        header('Location: ' . BASE_URL . '/instrumentales/index.php');
        exit;
    }
    
    /**
     * Elimina un instrumental
     */
    public function deleteInstrumental($id)
    {
        $instrumental = Instrumental::find($id);
        if (!$instrumental) {
            session()->flash('error', 'Instrumental no encontrado');
            header('Location: ' . BASE_URL . '/instrumentales/index.php');
            exit;
        }
        
        // Eliminar relaciones
        DB::delete("DELETE FROM pertenecer WHERE id_instrumental = ?", [$id]);
        DB::delete("DELETE FROM valoraciones WHERE id_instrumental = ?", [$id]);
        
        // Eliminar instrumental
        $instrumental->destroy();
        
        session()->flash('success', 'Instrumental eliminado correctamente');
        header('Location: ' . BASE_URL . '/instrumentales/index.php');
        exit;
    }
    
    /**
     * Gestión de usuarios
     */
    public function usuarios()
    {
        $usuarios = Usuario::all();
        
        view('admin.usuarios.index', [
            'usuarios' => $usuarios,
            'title' => 'Gestión de Usuarios - LoopLab'
        ]);
    }
    
    /**
     * Formulario para editar un usuario
     */
    public function editUsuario($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            session()->flash('error', 'Usuario no encontrado');
            header('Location: ' . BASE_URL . '/usuarios/index.php');
            exit;
        }
        
        view('admin.usuarios.edit', [
            'usuario' => $usuario,
            'title' => 'Editar Usuario - LoopLab'
        ]);
    }
    
    /**
     * Actualiza un usuario
     */
    public function updateUsuario($id, Request $request)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            session()->flash('error', 'Usuario no encontrado');
            header('Location: ' . BASE_URL . '/usuarios/index.php');
            exit;
        }
        
        // Validar datos
        if (empty($request->nombre) || empty($request->correo)) {
            session()->flash('error', 'El nombre y correo son obligatorios');
            header('Location: ' . BASE_URL . '/usuarios/edit.php?id=' . $id);
            exit;
        }
        
        // Actualizar el usuario
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->role = $request->role;
        
        // Actualizar contraseña solo si se proporciona una nueva
        if (!empty($request->password)) {
            $usuario->password = password_hash($request->password, PASSWORD_DEFAULT);
        }
        
        $usuario->update();
        
        session()->flash('success', 'Usuario actualizado correctamente');
        header('Location: ' . BASE_URL . '/usuarios/index.php');
        exit;
    }
    
    /**
     * Elimina un usuario
     */
    public function deleteUsuario($id)
    {
        // No permitir eliminar al usuario actual
        if ($id == Auth::id()) {
            session()->flash('error', 'No puedes eliminar tu propio usuario');
            header('Location: ' . BASE_URL . '/usuarios/index.php');
            exit;
        }
        
        $usuario = Usuario::find($id);
        if (!$usuario) {
            session()->flash('error', 'Usuario no encontrado');
            header('Location: ' . BASE_URL . '/usuarios/index.php');
            exit;
        }
        
        // Eliminar valoraciones del usuario
        DB::delete("DELETE FROM valoraciones WHERE id_usuario = ?", [$id]);
        
        // Eliminar usuario
        DB::delete("DELETE FROM usuarios WHERE id = ?", [$id]);
        
        session()->flash('success', 'Usuario eliminado correctamente');
        header('Location: ' . BASE_URL . '/usuarios/index.php');
        exit;
    }
    
    /**
     * Gestión de valoraciones
     */
    public function valoraciones()
    {
        $valoraciones = Valoracion::orderBy('fecha_valoracion', 'DESC')->get();
        
        view('admin.valoraciones.index', [
            'valoraciones' => $valoraciones,
            'title' => 'Gestión de Valoraciones - LoopLab'
        ]);
    }
    
    /**
     * Elimina una valoración
     */
    public function deleteValoracion($id)
    {
        $valoracion = Valoracion::find($id);
        if (!$valoracion) {
            session()->flash('error', 'Valoración no encontrada');
            header('Location: ' . BASE_URL . '/valoraciones/index.php');
            exit;
        }
        
        // Eliminar valoración
        DB::delete("DELETE FROM valoraciones WHERE id = ?", [$id]);
        
        session()->flash('success', 'Valoración eliminada correctamente');
        header('Location: ' . BASE_URL . '/valoraciones/index.php');
        exit;
    }
    
    public function productores()
    {
        $productores = Productor::all();
        
        // Obtener el conteo de instrumentales por productor
        $productorInstrumentales = $this->getProductorInstrumentales();
        
        view('admin.productores.index', [
            'productores' => $productores,
            'productorInstrumentales' => $productorInstrumentales,
            'title' => 'Gestión de Productores - LoopLab'
        ]);
    }
    
    /**
     * Formulario para crear un nuevo productor
     */
    public function createProductor()
    {
        view('admin.productores.create', [
            'title' => 'Crear Productor - LoopLab'
        ]);
    }
    
    /**
     * Guarda un nuevo productor
     */
    public function storeProductor(Request $request)
    {
        // Validar datos
        if (empty($request->nombre)) {
            session()->flash('error', 'El nombre es obligatorio');
            header('Location: ' . BASE_URL . '/productores/create.php');
            exit;
        }
        
        // Crear el productor
        $productor = new Productor();
        $productor->nombre = $request->nombre;
        $productor->insert();
        
        session()->flash('success', 'Productor creado correctamente');
        header('Location: ' . BASE_URL . '/productores/index.php');
        exit;
    }
    
    /**
     * Formulario para editar un productor
     */
    public function editProductor($id)
    {
        $productor = Productor::find($id);
        if (!$productor) {
            session()->flash('error', 'Productor no encontrado');
            header('Location: ' . BASE_URL . '/productores/index.php');
            exit;
        }
        
        view('admin.productores.edit', [
            'productor' => $productor,
            'title' => 'Editar Productor - LoopLab'
        ]);
    }
    
    /**
     * Actualiza un productor
     */
    public function updateProductor($id, Request $request)
    {
        $productor = Productor::find($id);
        if (!$productor) {
            session()->flash('error', 'Productor no encontrado');
            header('Location: ' . BASE_URL . '/productores/index.php');
            exit;
        }
        
        // Validar datos
        if (empty($request->nombre)) {
            session()->flash('error', 'El nombre es obligatorio');
            header('Location: ' . BASE_URL . '/productores/edit.php?id=' . $id);
            exit;
        }
        
        // Actualizar el productor
        $productor->nombre = $request->nombre;
        $productor->update();
        
        session()->flash('success', 'Productor actualizado correctamente');
        header('Location: ' . BASE_URL . '/productores/index.php');
        exit;
    }
    
    /**
     * Elimina un productor
     */
    public function deleteProductor($id)
    {
        $productor = Productor::find($id);
        if (!$productor) {
            session()->flash('error', 'Productor no encontrado');
            header('Location: ' . BASE_URL . '/productores/index.php');
            exit;
        }
        
        // Verificar si hay instrumentales asociados
        $sql = "SELECT COUNT(*) as count FROM instrumentales WHERE id_productor = ?";
        $result = DB::selectAssoc($sql, [$id]);
        
        if ((int)$result[0]['count'] > 0) {
            session()->flash('error', 'No se puede eliminar el productor porque tiene instrumentales asociados');
            header('Location: ' . BASE_URL . '/productores/index.php');
            exit;
        }
        
        // Eliminar productor
        DB::delete("DELETE FROM productores WHERE id = ?", [$id]);
        
        session()->flash('success', 'Productor eliminado correctamente');
        header('Location: ' . BASE_URL . '/productores/index.php');
        exit;
    }
    
    /**
     * Gestión de géneros
     */
    public function generos()
    {
        $generos = Genero::all();
        
        // Obtener el conteo de instrumentales por género
        $generosStats = $this->getGenerosStats();
        
        view('admin.generos.index', [
            'generos' => $generos,
            'generosStats' => $generosStats,
            'title' => 'Gestión de Géneros - LoopLab'
        ]);
    }
    
    /**
     * Formulario para crear un nuevo género
     */
    public function createGenero()
    {
        view('admin.generos.create', [
            'title' => 'Crear Género - LoopLab'
        ]);
    }
    
    /**
     * Guarda un nuevo género
     */
    public function storeGenero(Request $request)
    {
        // Validar datos
        if (empty($request->nombre)) {
            session()->flash('error', 'El nombre es obligatorio');
            header('Location: ' . BASE_URL . '/generos/create.php');
            exit;
        }
        
        // Crear el género
        $genero = new Genero();
        $genero->nombre = $request->nombre;
        $genero->insert();
        
        session()->flash('success', 'Género creado correctamente');
        header('Location: ' . BASE_URL . '/generos/index.php');
        exit;
    }
    
    /**
     * Formulario para editar un género
     */
    public function editGenero($id)
    {
        $genero = Genero::find($id);
        if (!$genero) {
            session()->flash('error', 'Género no encontrado');
            header('Location: ' . BASE_URL . '/generos/index.php');
            exit;
        }
        
        view('admin.generos.edit', [
            'genero' => $genero,
            'title' => 'Editar Género - LoopLab'
        ]);
    }
    
    /**
     * Actualiza un género
     */
    public function updateGenero($id, Request $request)
    {
        $genero = Genero::find($id);
        if (!$genero) {
            session()->flash('error', 'Género no encontrado');
            header('Location: ' . BASE_URL . '/generos/index.php');
            exit;
        }
        
        // Validar datos
        if (empty($request->nombre)) {
            session()->flash('error', 'El nombre es obligatorio');
            header('Location: ' . BASE_URL . '/generos/edit.php?id=' . $id);
            exit;
        }
        
        // Actualizar el género
        $genero->nombre = $request->nombre;
        $genero->update();
        
        session()->flash('success', 'Género actualizado correctamente');
        header('Location: ' . BASE_URL . '/generos/index.php');
        exit;
    }
    
    /**
     * Elimina un género
     */
    public function deleteGenero($id)
    {
        $genero = Genero::find($id);
        if (!$genero) {
            session()->flash('error', 'Género no encontrado');
            header('Location: ' . BASE_URL . '/generos/index.php');
            exit;
        }
        
        // Verificar si hay instrumentales asociados
        $sql = "SELECT COUNT(*) as count FROM pertenecer WHERE id_genero = ?";
        $result = DB::selectAssoc($sql, [$id]);
        
        if ((int)$result[0]['count'] > 0) {
            session()->flash('error', 'No se puede eliminar el género porque tiene instrumentales asociados');
            header('Location: ' . BASE_URL . '/generos/index.php');
            exit;
        }
        
        // Eliminar género
        DB::delete("DELETE FROM generos WHERE id = ?", [$id]);
        
        session()->flash('success', 'Género eliminado correctamente');
        header('Location: ' . BASE_URL . '/generos/index.php');
        exit;
    }
}
