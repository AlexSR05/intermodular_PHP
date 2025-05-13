<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;
use App\Core\Model;
use App\Core\QueryBuilder;

class Contact extends Model
{

    protected static string $table = 'contacts';
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

    public function update(): void
    {
        $sql = "UPDATE " . self::$table . " SET email = ?, nombre = ?, mensaje = ? WHERE id = ?";
        $params = [
            $this->email,
            $this->nombre,
            $this->mensaje,
            $this->id,
        ];
        DB::update($sql, $params);
    }
}
