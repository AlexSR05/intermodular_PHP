<?php 
declare(strict_types=1);

namespace App\Models;
use App\Core\DB;
use App\Core\Model;

class Genero extends Model
{
    protected static string $table = 'genero_musical';
    protected static array $fillable = ['nombre'];

    public function insert(): void
    {
        $sql = "INSERT INTO genero_musical (nombre) VALUES (?)";
        $this->id = DB::insert($sql, [$this->nombre]);
    }

    public function update(): void
    {
        $sql = "UPDATE genero_musical SET nombre = ? WHERE id = ?";
        DB::update($sql, [$this->nombre, $this->id]);
    }
}
