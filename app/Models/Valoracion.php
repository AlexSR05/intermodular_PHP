<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;

class Valoracion extends Model
{
    protected static string $table = 'valoraciones';
    protected static array $fillable = ['comentario', 'num_valoracion', 'id_usuario'];

    public function usuario()
    {
        if (!isset($this->id_usuario) || $this->id_usuario === null) {
            return null;
        }
        
        return Usuario::find($this->id_usuario);
    }
    
    public function insert(): void
    {
        // Verificar si la columna id_usuario existe en la tabla
        $checkColumn = DB::selectAssoc("
            SELECT COUNT(*) AS column_exists 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = '" . DB_NAME . "' 
            AND TABLE_NAME = 'valoraciones' 
            AND COLUMN_NAME = 'id_usuario'
        ");
        
        $columnExists = $checkColumn[0]['column_exists'] > 0;
        
        if ($columnExists) {
            // Si la columna existe, usamos la consulta con id_usuario
            $sql = "INSERT INTO " . static::$table . " (comentario, num_valoracion, id_usuario, fecha_valoracion) 
                    VALUES (?, ?, ?, NOW())";
            $params = [
                $this->comentario,
                $this->num_valoracion,
                $this->id_usuario
            ];
        } else {
            // Si la columna no existe, usamos la consulta sin id_usuario
            $sql = "INSERT INTO " . static::$table . " (comentario, num_valoracion, fecha_valoracion) 
                    VALUES (?, ?, NOW())";
            $params = [
                $this->comentario,
                $this->num_valoracion
            ];
        }
        
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table . " 
                SET comentario = ?, num_valoracion = ?, id_usuario = ?
                WHERE id = ?";
        $params = [
            $this->comentario,
            $this->num_valoracion,
            $this->id_usuario,
            $this->id
        ];
        DB::update($sql, $params);
    }
}







