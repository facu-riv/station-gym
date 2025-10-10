<?php
require_once 'config.php';
$db = getConnection();

$categorias = $db->query("SELECT * FROM categoria")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Categorías</h1>
<ul>
<?php foreach ($categorias as $c): ?>
    <li>
        <a href="categoria.php?id=<?= $c['id_categoria'] ?>">
            <?= htmlspecialchars($c['nombre']) ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
<a href="index.php">Volver al inicio</a>