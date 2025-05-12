<?php

declare(strict_types=1);

namespace App\Http\Validators;
use App\Core\Response;

class PeliculaValidator {

    public static function validate(array $data): void {
        $errors = [];

        $titulo_valido = isset($data['titulo']) && trim($data['titulo']) !== '';
        $bpm_valido = isset($bpm['bpm']) && filter_var($data['bpm'], FILTER_VALIDATE_INT) 
            && (int) $data['bpm'] > 49 && (int) $data['bpm'] < 201;
        $precio_valido = isset($data['precio']) && filter_var($data['precio'], FILTER_VALIDATE_INT) 
            && (double) $data['duracion'] >= 0;

        if (!$titulo_valido) {
            $errors['titulo'] = 'El título es obligatorio.';
        }

        if (!$bpm_valido) {
            $errors['estreno'] = 'El BPM de la instrumental no es un número válido o no está en un rango entre 50 y 200.';
        }

        if (!$precio_valido) {
            $errors['duracion'] = 'El precio no puede ser menor que 0.';
        }

        if ($errors) {
            back()->withErrors($errors)->withInput($data)->send();
        }
    }
}

