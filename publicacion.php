<?php
require_once 'config.php';
$db = getConnection();

$id = $_GET['id'] ?? 0;

$sql = "SELECT publicacion.*, categoria.nombre AS nombre_categoria
        FROM publicacion
        JOIN categoria ON publicacion.id_categoria = categoria.id_categoria
        WHERE id_publicacion = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$id]);
$pub = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php if ($pub): ?>
    <h1><?= htmlspecialchars($pub['titulo']) ?></h1>
    <p><strong>Categoría:</strong> <?= htmlspecialchars($pub['nombre_categoria']) ?></p>
    <p><?= htmlspecialchars($pub['contenido']) ?></p>
    <a href="index.php">Volver al listado</a>
<?php else: ?>
    <p>Publicación no encontrada.</p>
<?php endif; ?>