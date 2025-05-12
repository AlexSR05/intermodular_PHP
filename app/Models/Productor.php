<?php 
declare(strict_types=1);

namespace App\Models;
use App\Core\DB;
use App\Core\Model;

class Productor extends Model
{
    protected static string $table = 'productores';
    protected static array $fillable = ['nombre'];

    public function insert(): void
    {
        $sql = "INSERT INTO productores (nombre) VALUES (?)";
        $this->id = DB::insert($sql, [$this->nombre]);
    }

    public function update(): void
    {
        $sql = "UPDATE productores SET nombre = ? WHERE id = ?";
        DB::update($sql, [$this->nombre, $this->id]);
    }
}
