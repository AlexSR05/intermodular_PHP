<?php
declare(strict_types=1);

namespace App\Models;
use app\Core\DB;
use App\Core\Model;
use App\Core\QueryBuilder;

class Venta extends Model
{
    protected static string $table = 'ventas';
    protected static array $fillable = ['fecha', 'usuario_id', 'cantidad_total', 'importe_total'];
    protected static array $relations = ['usuario', 'articulos'];

    /** @override */
    public function insert(): void
    {
        $table = self::$table;
        $sql = "INSERT INTO $table (fecha, usuario_id, cantidad_total, importe_total) VALUES (?, ?, ?, ?)";
        $params = [$this->fecha, $this->usuario_id, $this->cantidad_total, $this->importe_total];
        $this->id = DB::insert($sql, $params);
    }

    /** @override */
    public function update(): void
    {
        $table = self::$table;
        $sql = "UPDATE $table
                SET fecha = ?, usuario_id = ?, cantidad_total = ?, importe_total = ?
                WHERE id = ?";
        $params = [$this->fecha, $this->usuario_id, $this->cantidad_total, $this->importe_total, $this->id];
        DB::update($sql, $params);
    }

    public function usuario(): ?Usuario
    {
        return Usuario::find($this->usuario_id);
    }

    public function articulos(): QueryBuilder
    {
        $sql = "SELECT a.*, va.venta_id, va.cantidad, va.precio_unitario, va.variante_id, va.tipo_variante
        FROM articulos a
        JOIN venta_articulo va ON a.id = va.articulo_id
        WHERE va.venta_id = :id";
        $params = [':id' => $this->id];

        return new QueryBuilder(Color::class, $sql, $params);
    }
}
