<h1><?= $instrumental->titulo ?></h1>
<p>Precio: <?= $instrumental->precio ?>€</p>
<p>Productor: <?= $instrumental->productor()?->nombre ?></p>

<h3>Géneros Musicales:</h3>
<ul>
<?php foreach ($instrumental->generos() as $genero): ?>
    <li><?= $genero->nombre ?></li>
<?php endforeach; ?>
</ul>

<a href="/instrumentales/<?= $instrumental->id ?>/edit">Editar</a>
