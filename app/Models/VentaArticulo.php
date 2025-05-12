<?php
declare(strict_types=1);

namespace App\Models;
use app\Core\DB;
use App\Core\Model;
use App\Core\QueryBuilder;

class VentaArticulo extends Model
{
    protected static string $table = 'venta_articulo';
    protected static array $fillable = ['venta_id', 'articulo_id', 'articulo_tipo', 'variante_id', 'variante_sku', 'cantidad', 'precio_ud'];
    protected static array $relations = ['venta', 'articulo'];

    /** @override */
    public function insert(): void
    {
        $table = self::$table;
        $sql = "INSERT INTO $table (venta_id , articulo_id, articulo_tipo, variante_id, variante_sku, cantidad, precio_ud) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$this->venta_id, $this->articulo_id, $this->articulo_tipo, $this->variante_id, $this->variante_sku, $this->cantidad, $this->precio_ud];
        $this->id = DB::insert($sql, $params);
    }

    /** @override */
    public function update(): void
    {
        $table = self::$table;
        $sql = "UPDATE $table
                SET venta_id  = ?, articulo_id = ?, articulo_tipo = ?, variante_id = ?, variante_sku = ?, cantidad = ?, precio_ud = ?
                WHERE id = ?";
        $params = [$this->venta_id, $this->articulo_id, $this->articulo_tipo, $this->variante_id, $this->variante_sku, $this->cantidad, $this->precio_ud, $this->id];
        DB::update($sql, $params);
    }

    public function venta(): ?Venta
    {
        return Venta::find($this->venta_id);
    }

    public function articulo(): ?Articulo
    {
        return Articulo::find($this->articulo_id);
    }

}
