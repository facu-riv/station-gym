<?php
require_once 'config.php';
$db = getConnection();

$id = $_GET['id'] ?? 0;

// Nombre de la categoría
$stmt = $db->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
$stmt->execute([$id]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

// Publicaciones de esa categoría
$stmt = $db->prepare("SELECT * FROM publicacion WHERE id_categoria = ?");
$stmt->execute([$id]);
$publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Publicaciones en <?= htmlspecialchars($categoria['nombre']) ?></h1>
<ul>
<?php foreach ($publicaciones as $p): ?>
    <li>
        <strong><?= htmlspecialchars($p['titulo']) ?></strong>
        <a href="publicacion.php?id=<?= $p['id_publicacion'] ?>">Ver detalle</a>
    </li>
<?php endforeach; ?>
</ul>
<a href="categorias.php">Volver a categorías</a>