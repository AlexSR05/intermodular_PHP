<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Instrumental;
use App\Models\Productor;
use App\Models\Genero;
use App\Models\Valoracion;
use App\Core\DB;
use App\Core\Router;

class InstrumentalController
{
    public function index(): void
    {
        $instrumentales = Instrumental::orderBy('fecha_creacion', 'DESC')->limit(4)->get();
        
        // Obtener todas las valoraciones directamente del modelo
        $valoraciones = Valoracion::orderBy('fecha_valoracion', 'DESC')->get();
        
        // Añadir depuración para verificar las valoraciones
        // echo '<pre>Valoraciones: ' . print_r($valoraciones, true) . '</pre>';
        
        view('instrumentales.index', [
            'instrumentales' => $instrumentales,
            'valoraciones' => $valoraciones
        ]);
    }

    public function showAll(): void
    {
        $search = request()->search ?? '';
        
        if (!empty($search)) {
            // Búsqueda por título, género o productor
            $instrumentales = Instrumental::where('titulo', 'LIKE', "%$search%")
                ->orderBy('fecha_creacion', 'DESC')
                ->get();
                
            // Si no hay resultados directos por título, intentamos buscar por género
            if (empty($instrumentales)) {
                $generoId = DB::selectAssoc("SELECT id FROM genero_musical WHERE nombre LIKE ?", ["%$search%"]);
                if (!empty($generoId)) {
                    $ids = DB::selectAssoc("SELECT id_instrumental FROM pertenecer WHERE id_genero = ?", [$generoId[0]['id']]);
                    $instrumentalIds = array_column($ids, 'id_instrumental');
                    
                    if (!empty($instrumentalIds)) {
                        $placeholders = implode(',', array_fill(0, count($instrumentalIds), '?'));
                        $instrumentales = DB::select(
                            Instrumental::class,
                            "SELECT * FROM instrumentales WHERE id IN ($placeholders) ORDER BY fecha_creacion DESC",
                            $instrumentalIds
                        );
                    }
                }
            }
            
            // Si aún no hay resultados, intentamos buscar por productor
            if (empty($instrumentales)) {
                $productorId = DB::selectAssoc("SELECT id FROM productores WHERE nombre LIKE ?", ["%$search%"]);
                if (!empty($productorId)) {
                    $instrumentales = Instrumental::where('id_productor', $productorId[0]['id'])
                        ->orderBy('fecha_creacion', 'DESC')
                        ->get();
                }
            }
        } else {
            $instrumentales = Instrumental::orderBy('fecha_creacion', 'DESC')->get();
        }
        
        view('instrumentales.instrumentales_index', ['instrumentales' => $instrumentales, 'title' => 'LoopLab - Nuestras Instrumentales']);
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
