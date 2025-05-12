<?php
declare(strict_types=1);

namespace App\Contracts;

interface Stockeable
{
    public static function find(int $id): ?static;
    public function decrementStock(int $cantidad): void;
    public function incrementStock(int $cantidad): void;
}