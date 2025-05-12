<form method="POST" action="<?= isset($instrumental) ? "/instrumentales/{$instrumental->id}/update" : "/instrumentales/store" ?>">
    <label>Título: <input type="text" name="titulo" value="<?= $instrumental->titulo ?? '' ?>"></label><br>
    <label>Precio: <input type="number" name="precio" value="<?= $instrumental->precio ?? '' ?>"></label><br>

    <label>Productor:
        <select name="productor_id">
            <?php foreach ($productores as $prod): ?>
                <option value="<?= $prod->id ?>" <?= (isset($instrumental) && $prod->id == $instrumental->productor_id) ? 'selected' : '' ?>>
                    <?= $prod->nombre ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>

    <label>Géneros:</label><br>
    <?php foreach ($generos as $genero): ?>
        <label>
            <input type="checkbox" name="generos[]" value="<?= $genero->id ?>"
                <?= isset($instrumental) && in_array($genero->id, array_map(fn($g) => $g->id, $instrumental->generos())) ? 'checked' : '' ?>>
            <?= $genero->nombre ?>
        </label><br>
    <?php endforeach; ?>

    <button type="submit">Guardar</button>
</form>
