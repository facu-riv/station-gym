<?php
require_once 'config.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>

<h1>Panel de Administración</h1>
<p>Bienvenido, <?= htmlspecialchars($_SESSION['admin']) ?>!</p>

<ul>
    <li><a href="index.php">Ver ítems públicos</a></li>
    <li><a href="categorias.php">Ver categorías</a></li>
    <li><a href="logout.php">Cerrar sesión</a></li>
</ul>