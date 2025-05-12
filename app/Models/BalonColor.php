<?php
declare(strict_types=1);

namespace App\Models;

use App\Contracts\Stockeable;
use App\Core\DB;
use App\Core\Model;

class BalonColor extends Model implements Stockeable
{
    protected static string $table = 'balon_color';
    protected static array $fillable = ['balon_id', 'color_id', 'sku', 'stock', 'precio'];
    protected static array $relations = ['balon', 'color'];

    /** @override */
    public function insert(): void
    {
        $table = self::$table;
        $sql = "INSERT INTO $table (balon_id, color_id, sku, stock, precio)
                VALUES (?, ?, ?, ?, ?)";
        $params = [
            $this->balon_id,
            $this->color_id,
            $this->sku,
            $this->stock,
            $this->precio
        ];
        $this->id = DB::insert($sql, $params);
    }

    /** @override */
    public function update(): void
    {
        $table = self::$table;
        $sql = "UPDATE $table 
                SET sku = ?, stock = ?, precio = ?
                WHERE balon_id = ? AND color_id = ?";
        $params = [
            $this->sku,
            $this->stock,
            $this->precio,
            $this->balon_id,
            $this->color_id
        ];
        DB::update($sql, $params);
    }

    public static function makeFromBalon(Balon $balon): self
    {
        $balonColor = new self();
        $balonColor->balon_id = $balon->id;
        $balonColor->color_id = $balon->color_id;
        $balonColor->sku = $balon->sku;
        $balonColor->stock = $balon->stock;
        $balonColor->precio = $balon->precio;
        return $balonColor;
    }

    public function balon(): ?Balon
    {
        return Balon::find($this->balon_id);
    }

    public function color(): ?Color
    {
        return Color::find($this->color_id);
    }

    /** @override */
    public function decrementStock(int $cantidad): void
    {
        if ($this->stock < $cantidad) {
            throw new \RuntimeException("No hay stock suficiente.");
        }
        $this->stock -= $cantidad;
        $this->save();
    }

    /** @override */
    public function incrementStock(int $cantidad): void
    {
        $this->stock += $cantidad;
        $this->save();
    }
}
