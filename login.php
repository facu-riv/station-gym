<?php
require_once 'config.php';
$db = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE email = ? AND contraseña = ? AND es_admin = 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email, $pass]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['admin'] = $user['nombre'];
        header('Location: admin.php');
        exit;
    } else {
        echo "<p>Credenciales incorrectas.</p>";
    }
}
?>

<h1>Login de Administrador</h1>
<form method="POST">
    <input type="text" name="email" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
</form>