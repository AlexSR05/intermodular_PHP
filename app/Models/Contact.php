<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;
use App\Core\Model;
use App\Core\QueryBuilder;

class Contact
{
    protected ?int $id = null;
    protected string $email;
    protected string $nombre;
    protected string $mensaje;   
    protected static string $table = 'contacto';
    protected static array $fillable = ['email', 'nombre', 'mensaje'];

        public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table . " (email, nombre, mensaje)
                VALUES (?, ?, ?)";
        $params = [
            $this->email,
            $this->nombre,
            $this->mensaje,
        ];
        $this->id = DB::insert($sql, $params);
        }
}
