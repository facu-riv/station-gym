<?php
require_once 'config.php';
$db = getConnection();

$sql = "SELECT publicacion.*, categoria.nombre AS nombre_categoria
        FROM publicacion
        JOIN categoria ON publicacion.id_categoria = categoria.id_categoria";
$publicaciones = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Listado de Publicaciones</h1>
<ul>
<?php foreach ($publicaciones as $p): ?>
    <li>
        <strong><?= htmlspecialchars($p['titulo']) ?></strong>
        (Categoría: <?= htmlspecialchars($p['nombre_categoria']) ?>)
        <a href="publicacion.php?id=<?= $p['id_publicacion'] ?>">Ver detalle</a>
    </li>
<?php endforeach; ?>
</ul>

<a href="categorias.php">Ver categorías</a>