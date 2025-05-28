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
        // Obtener datos directamente de $_POST para asegurar que se reciben
        $titulo = trim($_POST['titulo'] ?? '');
        $precio = $_POST['precio'] ?? '';
        $id_productor = $_POST['id_productor'] ?? '';
        $bpm = $_POST['bpm'] ?? 0;
        $genero = $_POST['genero'] ?? ''; // Cambiado de 'generos' a 'genero' (singular)
        
        // Debug: Verificar los datos obtenidos
        if (defined('DEBUG') && DEBUG) {
            error_log("AdminController::storeInstrumental - Título: '$titulo'");
            error_log("AdminController::storeInstrumental - Precio: '$precio'");
            error_log("AdminController::storeInstrumental - ID Productor: '$id_productor'");
            error_log("AdminController::storeInstrumental - Género: '$genero'");
            error_log("AdminController::storeInstrumental - Datos POST: " . print_r($_POST, true));
        }
        
        // Validar datos
        if (empty($titulo)) {
            session()->flash('error', 'El título es obligatorio');
            header('Location: ' . BASE_URL . '/admin/instrumentales/create.php');
            exit;
        }
        
        if (empty($precio) || !is_numeric($precio) || $precio <= 0) {
            session()->flash('error', 'El precio debe ser un número mayor que 0');
            header('Location: ' . BASE_URL . '/admin/instrumentales/create.php');
            exit;
        }
        
        if (empty($id_productor) || !is_numeric($id_productor)) {
            session()->flash('error', 'Debe seleccionar un productor válido');
            header('Location: ' . BASE_URL . '/admin/instrumentales/create.php');
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
        $instrumental->titulo = $titulo;
        $instrumental->bpm = (int)$bpm;
        $instrumental->precio = (float)$precio;
        $instrumental->id_productor = (int)$id_productor;
        $instrumental->imagen = $imagen;
        $instrumental->audio = $audio;
        $instrumental->insert();
        
        // Asociar género (solo uno)
        if (!empty($genero) && is_numeric($genero)) {
            DB::insert("INSERT INTO pertenecer (id_instrumental, id_genero) VALUES (?, ?)", [$instrumental->id, (int)$genero]);
        }
        
        session()->flash('success', 'Instrumental creado correctamente');
        header('Location: ' . BASE_URL . '/admin/instrumentales.php');
        exit;
    }
    
    /**
     * Formulario para editar un instrumental
     */
    public function editInstrumental($id)
    {
        $instrumental = Instrumental::find((int) $id);
        if (!$instrumental) {
            session()->flash('error', 'Instrumental no encontrado');
            header('Location: ' . BASE_URL . '/admin/instrumentales.php');
            exit;
        }
        
        $productores = Productor::all();
        $generos = Genero::all();
        
        // Obtener el género asociado al instrumental (solo uno)
        $sql = "SELECT id_genero FROM pertenecer WHERE id_instrumental = ? LIMIT 1";
        $result = DB::selectAssoc($sql, [$id]);
        $instrumentalGenero = !empty($result) ? (int)$result[0]['id_genero'] : null;
        
        view('admin.instrumentales.edit', [
            'instrumental' => $instrumental,
            'productores' => $productores,
            'generos' => $generos,
            'title' => 'Editar Instrumental - LoopLab'
        ]);
    }
    
    /**
     * Actualiza un instrumental
     */
    public function updateInstrumental($id, Request $request)
    {
        $instrumental = Instrumental::find((int) $id);
        if (!$instrumental) {
            session()->flash('error', 'Instrumental no encontrado');
            header('Location: ' . BASE_URL . '/admin/instrumentales.php');
            exit;
        }
        
        // Obtener datos directamente de $_POST para asegurar que se reciben
        $titulo = trim($_POST['titulo'] ?? '');
        $precio = $_POST['precio'] ?? '';
        $id_productor = $_POST['id_productor'] ?? '';
        $bpm = $_POST['bpm'] ?? 0;
        $genero = $_POST['genero'] ?? '';
        
        // Debug: Verificar los datos obtenidos
        if (defined('DEBUG') && DEBUG) {
            error_log("AdminController::updateInstrumental - ID: $id");
            error_log("AdminController::updateInstrumental - Título: '$titulo'");
            error_log("AdminController::updateInstrumental - Precio: '$precio'");
            error_log("AdminController::updateInstrumental - ID Productor: '$id_productor'");
            error_log("AdminController::updateInstrumental - Género: '$genero'");
            error_log("AdminController::updateInstrumental - Datos POST: " . print_r($_POST, true));
        }
        
        // Validar datos
        if (empty($titulo)) {
            session()->flash('error', 'El título es obligatorio');
            header('Location: ' . BASE_URL . '/admin/instrumentales/edit.php?id=' . $id);
            exit;
        }
        
        if (empty($precio) || !is_numeric($precio) || $precio <= 0) {
            session()->flash('error', 'El precio debe ser un número mayor que 0');
            header('Location: ' . BASE_URL . '/admin/instrumentales/edit.php?id=' . $id);
            exit;
        }
        
        if (empty($id_productor) || !is_numeric($id_productor)) {
            session()->flash('error', 'Debe seleccionar un productor válido');
            header('Location: ' . BASE_URL . '/admin/instrumentales/edit.php?id=' . $id);
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
        $instrumental->titulo = $titulo;
        $instrumental->bpm = (int)$bpm;
        $instrumental->precio = (float)$precio;
        $instrumental->id_productor = (int)$id_productor;
        $instrumental->update();
        
        // Actualizar género (eliminar el anterior y agregar el nuevo)
        DB::delete("DELETE FROM pertenecer WHERE id_instrumental = ?", [$id]);
        if (!empty($genero) && is_numeric($genero)) {
            DB::insert("INSERT INTO pertenecer (id_instrumental, id_genero) VALUES (?, ?)", [$id, (int)$genero]);
        }
        
        session()->flash('success', 'Instrumental actualizado correctamente');
        header('Location: ' . BASE_URL . '/admin/instrumentales.php');
        exit;
    }
    
    /**
     * Elimina un instrumental
     */
    public function deleteInstrumental($id)
    {
        $instrumental = Instrumental::find((int) $id);
        if (!$instrumental) {
            session()->flash('error', 'Instrumental no encontrado');
            header('Location: ' . BASE_URL . '/admin/instrumentales.php');
            exit;
        }
        
        // Eliminar relaciones
        DB::delete("DELETE FROM pertenecer WHERE id_instrumental = ?", [$id]);
        // Eliminar esta línea porque la tabla valoraciones no tiene id_instrumental
        // DB::delete("DELETE FROM valoraciones WHERE id_instrumental = ?", [$id]);
        
        // Eliminar instrumental
        $instrumental->destroy();
        
        session()->flash('success', 'Instrumental eliminado correctamente');
        header('Location: ' . BASE_URL . '/admin/instrumentales.php');
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
    public function editUsuario(int $id)
    {
        // Debug: Verificar el ID recibido
        if (defined('DEBUG') && DEBUG) {
            error_log("AdminController::editUsuario - ID recibido: " . $id);
        }
        
        $usuario = Usuario::find($id);
        
        if (!$usuario) {
            session()->flash('error', 'Usuario no encontrado con ID: ' . $id);
            header('Location: ' . BASE_URL . '/admin/usuarios.php');
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
    public function updateUsuario(int $id, Request $request)
    {
        // Debug: Verificar el ID recibido
        if (defined('DEBUG') && DEBUG) {
            error_log("AdminController::updateUsuario - ID recibido: " . $id);
            error_log("AdminController::updateUsuario - Datos POST: " . print_r($_POST, true));
        }
        
        $usuario = Usuario::find($id);
        
        if (!$usuario) {
            session()->flash('error', 'Usuario no encontrado con ID: ' . $id);
            header('Location: ' . BASE_URL . '/admin/usuarios.php');
            exit;
        }
        
        // Obtener datos directamente de $_POST para asegurar que se reciben
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = $_POST['role'] ?? 'user';
        $password = $_POST['password'] ?? '';
        
        // Debug: Verificar los datos obtenidos
        if (defined('DEBUG') && DEBUG) {
            error_log("AdminController::updateUsuario - Nombre: '$nombre'");
            error_log("AdminController::updateUsuario - Email: '$email'");
            error_log("AdminController::updateUsuario - Role: '$role'");
        }
        
        // Validar datos
        if (empty($nombre)) {
            session()->flash('error', 'El nombre es obligatorio');
            header('Location: ' . BASE_URL . '/admin/usuarios/edit.php?id=' . $id);
            exit;
        }
        
        if (empty($email)) {
            session()->flash('error', 'El email es obligatorio');
            header('Location: ' . BASE_URL . '/admin/usuarios/edit.php?id=' . $id);
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            session()->flash('error', 'El email no tiene un formato válido');
            header('Location: ' . BASE_URL . '/admin/usuarios/edit.php?id=' . $id);
            exit;
        }
        
        // Verificar si el email ya existe (excepto para el usuario actual)
        $existingUser = Usuario::where('email', $email)->first();
        if ($existingUser && $existingUser->id !== $id) {
            session()->flash('error', 'El email ya está en uso por otro usuario');
            header('Location: ' . BASE_URL . '/admin/usuarios/edit.php?id=' . $id);
            exit;
        }
        
        // Actualizar el usuario
        $usuario->nombre = $nombre;
        $usuario->email = $email;
        $usuario->role = $role;
        
        // Actualizar contraseña solo si se proporciona una nueva
        if (!empty($password)) {
            $usuario->password = password_hash($password, PASSWORD_DEFAULT);
        }
        
        $usuario->update();
        
        session()->flash('success', 'Usuario actualizado correctamente');
        header('Location: ' . BASE_URL . '/admin/usuarios.php');
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
            header('Location: ' . BASE_URL . '/admin/usuarios.php');
            exit;
        }
        
        $usuario = Usuario::find((int) $id);
        if (!$usuario) {
            session()->flash('error', 'Usuario no encontrado');
            header('Location: ' . BASE_URL . '/admin/usuarios.php');
            exit;
        }
        
        // Eliminar valoraciones del usuario
        DB::delete("DELETE FROM valoraciones WHERE id_usuario = ?", [$id]);
        
        // Eliminar usuario
        DB::delete("DELETE FROM usuarios WHERE id = ?", [$id]);
        
        session()->flash('success', 'Usuario eliminado correctamente');
        header('Location: ' . BASE_URL . '/admin/usuarios.php');
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
        $valoracion = Valoracion::find((int) $id);
        if (!$valoracion) {
            session()->flash('error', 'Valoración no encontrada');
            header('Location: ' . BASE_URL . '/admin/valoraciones.php');
            exit;
        }
        
        // Eliminar valoración
        DB::delete("DELETE FROM valoraciones WHERE id = ?", [$id]);
        
        session()->flash('success', 'Valoración eliminada correctamente');
        header('Location: ' . BASE_URL . '/admin/valoraciones.php');
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
     * Formulario para crear un nuevo género
     */
    public function createGenero()
    {
        view('admin.generos.create', [
            'title' => 'Crear Género - LoopLab'
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
            header('Location: ' . BASE_URL . '/admin/productores/create.php');
            exit;
        }
        
        // Crear el productor
        $productor = new Productor();
        $productor->nombre = $request->nombre;
        $productor->insert();
        
        session()->flash('success', 'Productor creado correctamente');
        header('Location: ' . BASE_URL . '/admin/productores.php');
        exit;
    }

    /**
     * Guarda un nuevo género
     */
    public function storeGenero(Request $request)
    {
        // Validar datos
        if (empty($request->nombre)) {
            session()->flash('error', 'El nombre es obligatorio');
            header('Location: ' . BASE_URL . '/admin/generos/create.php');
            exit;
        }
        
        // Crear el género
        $genero = new Genero();
        $genero->nombre = $request->nombre;
        $genero->insert();
        
        session()->flash('success', 'Género creado correctamente');
        header('Location: ' . BASE_URL . '/admin/generos.php');
        exit;
    }
    
    /**
     * Formulario para editar un productor
     */
    public function editProductor($id)
    {
        $productor = Productor::find((int) $id);
        if (!$productor) {
            session()->flash('error', 'Productor no encontrado');
            header('Location: ' . BASE_URL . '/admin/productores.php');
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
        $productor = Productor::find((int) $id);
        if (!$productor) {
            session()->flash('error', 'Productor no encontrado');
            header('Location: ' . BASE_URL . '/admin/productores.php');
            exit;
        }
        
        // Validar datos
        if (empty($request->nombre)) {
            session()->flash('error', 'El nombre es obligatorio');
            header('Location: ' . BASE_URL . '/admin/productores/edit.php?id=' . $id);
            exit;
        }
        
        // Actualizar el productor
        $productor->nombre = $request->nombre;
        $productor->update();
        
        session()->flash('success', 'Productor actualizado correctamente');
        header('Location: ' . BASE_URL . '/admin/productores.php');
        exit;
    }
    
    /**
     * Elimina un productor
     */
    public function deleteProductor($id)
    {
        $productor = Productor::find((int) $id);
        if (!$productor) {
            session()->flash('error', 'Productor no encontrado');
            header('Location: ' . BASE_URL . '/admin/productores.php');
            exit;
        }
        
        // Verificar si hay instrumentales asociados
        $sql = "SELECT COUNT(*) as count FROM instrumentales WHERE id_productor = ?";
        $result = DB::selectAssoc($sql, [$id]);
        
        if ((int)$result[0]['count'] > 0) {
            session()->flash('error', 'No se puede eliminar el productor porque tiene instrumentales asociados');
            header('Location: ' . BASE_URL . '/admin/productores.php');
            exit;
        }
        
        // Eliminar productor
        DB::delete("DELETE FROM productores WHERE id = ?", [$id]);
        
        session()->flash('success', 'Productor eliminado correctamente');
        header('Location: ' . BASE_URL . '/admin/productores.php');
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
     * Formulario para editar un género
     */
    public function editGenero($id)
    {
        $genero = Genero::find((int) $id);
        if (!$genero) {
            session()->flash('error', 'Género no encontrado');
            header('Location: ' . BASE_URL . '/admin/generos.php');
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
        $genero = Genero::find((int) $id);
        if (!$genero) {
            session()->flash('error', 'Género no encontrado');
            header('Location: ' . BASE_URL . '/admin/generos.php');
            exit;
        }
        
        // Validar datos
        if (empty($request->nombre)) {
            session()->flash('error', 'El nombre es obligatorio');
            header('Location: ' . BASE_URL . '/admin/generos/edit.php?id=' . $id);
            exit;
        }
        
        // Actualizar el género
        $genero->nombre = $request->nombre;
        $genero->update();
        
        session()->flash('success', 'Género actualizado correctamente');
        header('Location: ' . BASE_URL . '/admin/generos.php');
        exit;
    }
    
    /**
     * Elimina un género
     */
    public function deleteGenero($id)
    {
        $genero = Genero::find((int) $id);
        if (!$genero) {
            session()->flash('error', 'Género no encontrado');
            header('Location: ' . BASE_URL . '/admin/generos.php');
            exit;
        }
        
        // Verificar si hay instrumentales asociados
        $sql = "SELECT COUNT(*) as count FROM pertenecer WHERE id_genero = ?";
        $result = DB::selectAssoc($sql, [$id]);
        
        if ((int)$result[0]['count'] > 0) {
            session()->flash('error', 'No se puede eliminar el género porque tiene instrumentales asociados');
            header('Location: ' . BASE_URL . '/admin/generos.php');
            exit;
        }
        
        // Eliminar género
        DB::delete("DELETE FROM genero_musical WHERE id = ?", [$id]);
        
        session()->flash('success', 'Género eliminado correctamente');
        header('Location: ' . BASE_URL . '/admin/generos.php');
        exit;
    }
}