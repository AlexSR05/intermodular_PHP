<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Instrumental;
use App\Models\Productor;
use App\Models\Genero;
use App\Core\DB;
use App\Core\Router;

class InstrumentalController
{
    public function index(): void
    {
        $instrumentales = Instrumental::orderBy('fecha_creacion', 'DESC')->limit(4)->get();
        //echo "<pre>";
        //print_r($instrumentales); echo "</pre>";
        view('instrumentales.index', ['instrumentales' => $instrumentales]);
    }

    public function showAll(): void
    {
        $instrumentales = Instrumental::all();
        //echo "<pre>";
        //print_r($instrumentales); echo "</pre>";
        view('instrumentales.instrumentales_index', ['instrumentales' => $instrumentales]);
    }

    public function show(int $id): void
    {
        $instrumental = Instrumental::find($id);
        view('instrumentales.show', ['instrumental' => $instrumental]);
    }

    public function create(): void
    {
        $productores = Productor::all();
        $generos = Genero::all();
        view('instrumentales.create', compact('productores', 'generos'));
    }

    public function store(): void
    {
        $instrumental = new Instrumental($_POST);
        $instrumental->insert();

        if (!empty($_POST['generos'])) {
            foreach ($_POST['generos'] as $genero_id) {
                DB::insert("INSERT INTO pertenecer (id_instrumental, id_genero) VALUES (?, ?)", [$instrumental->id, $genero_id]);
            }
        }

        header('Location: /instrumentales');
        exit;
    }

    public function edit(int $id): void
    {
        $instrumental = Instrumental::find($id);
        $productores = Productor::all();
        $generos = Genero::all();
        view('instrumentales.edit', compact('instrumental', 'productores', 'generos'));
    }

    public function update(int $id): void
    {
        $instrumental = Instrumental::find($id);
        $instrumental->fill($_POST);
        $instrumental->update();

        DB::delete("DELETE FROM pertenecer WHERE id_instrumental = ?", [$id]);
        foreach ($_POST['generos'] as $genero_id) {
            DB::insert("INSERT INTO pertenecer (id_instrumental, id_genero) VALUES (?, ?)", [$id, $genero_id]);
        }

        header('Location: /instrumentales');
        exit;
    }

    public function delete(int $id): void
    {
        DB::delete("DELETE FROM pertenecer WHERE id_instrumental = ?", [$id]);
        $instrumental = Instrumental::find($id);
        $instrumental->destroy();
        header('Location: /instrumentales');
        exit;
    }
}
