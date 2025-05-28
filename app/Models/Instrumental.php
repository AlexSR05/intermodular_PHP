<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;
use App\Core\Model;
use App\Core\QueryBuilder;

class Instrumental extends Model
{
    protected static string $table = 'instrumentales';
    protected static array $fillable = ['titulo','bpm','fecha_creacion', 'id_productor', 'imagen', 'audio','precio'];
    protected static array $relations = ['productores', 'genero','pertenecer'];

    public static function all(): array
    {
        $sql = "SELECT * FROM " . static::$table;
        return DB::select(static::class, $sql);
    }

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table . " (titulo, bpm, id_productor, imagen, audio, precio)
                VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $this->titulo,
            $this->bpm,
            $this->id_productor,
            $this->imagen,
            $this->audio,
            $this->precio,
        ];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table . "
                SET titulo = ?, id_productor = ?, precio = ?, bpm = ?, imagen = ?, audio = ?
                WHERE id = ?";
        $params = [
            $this->titulo,
            $this->id_productor,
            $this->precio,
            $this->bpm,
            $this->imagen,
            $this->audio,
            $this->id
        ];
        DB::update($sql, $params);
    }

    public function destroy(): void
    {
        $sql = "DELETE FROM " . self::$table . " WHERE id = ?";
        $params = [$this->id];
        DB::update($sql, $params);
    }

    public function productor(): ?Productor
    {
        $sql = "SELECT p.*
                FROM productores p
                JOIN instrumentales i ON p.id = i.id_productor
                WHERE i.id = ?";

        $params = [$this->id];
        return DB::selectOne(Productor::class, $sql, $params);
    }

    public function genero(): ?Genero
    {

        $sql = "SELECT gm.*
                FROM genero_musical gm
                JOIN pertenecer p ON gm.id = p.id_genero
                WHERE p.id_instrumental = ?";
        
        $params = [$this->id];

        return DB::selectOne(Genero::class, $sql, $params);

    }

    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            if (in_array($key, self::$fillable, true)) {
                $this->$key = $value;
            }
        }
    }
}