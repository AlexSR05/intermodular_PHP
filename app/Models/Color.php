<?php
declare(strict_types=1);

namespace App\Models;
use App\Core\DB;
use App\Core\Model;
use App\Core\QueryBuilder;

class Color extends Model
{
    protected static string $table = 'colores';
    protected static array $fillable = ['nombre'];
    protected static array $relations = ['balones', 'zapatillas'];
    protected static array $pivots = ['color_id', 'sku', 'stock', 'precio'];

    /** @override */
    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table . " (nombre) VALUES (?)";
        $params = [$this->nombre];
        $this->id = DB::insert($sql, $params);
    }

    /** @override */
    public function update(): void
    {
        $sql = "UPDATE " . self::$table . " SET nombre = ? WHERE id = ?";
        $params = [$this->nombre, $this->id];
        DB::update($sql, $params);
    }

    public function balones(): QueryBuilder
    {
        $sql = "SELECT b.*, bc.sku, bc.stock, bc.precio
                FROM balones b
                JOIN balon_color bc ON b.id = bc.balon_id
                WHERE bc.color_id = :id";
        $params  = [':id' => $this->id];

        return new QueryBuilder(Balon::class, $sql, $params);
    }

    public function zapatillas(): QueryBuilder
    {
        $sql = "SELECT z.*, ztc.sku, ztc.stock, ztc.precio
                FROM zapatillas z
                JOIN zapatilla_talla_color ztc ON z.id = ztc.zapatilla_id
                WHERE ztc.color_id = :id";
        $params  = [':id' => $this->id];

        return new QueryBuilder(Zapatilla::class, $sql, $params);
    }
}
