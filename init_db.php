<?php
require_once 'config.php';
try {
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `".DB_NAME."` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    $pdo->exec("USE `".DB_NAME."`");

    $pdo->exec("CREATE TABLE IF NOT EXISTS tipos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS actividades (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) NOT NULL,
        descripcion TEXT,
        imagen VARCHAR(255),
        tipo_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (tipo_id) REFERENCES tipos(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        nombre VARCHAR(100),
        rol VARCHAR(20) DEFAULT 'admin'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("INSERT IGNORE INTO tipos (id,nombre) VALUES (1,'Gimnasia'),(2,'Baile'),(3,'Meditación'),(4,'Combate')");

    $pdo->exec("INSERT IGNORE INTO actividades (id,nombre,descripcion,imagen,tipo_id) VALUES
        (1,'Funcional','Entrenamiento funcional: fuerza y resistencia.','img/funcional.png',1),
        (2,'Zumba','Clase de baile enérgica para cardio y coordinación.','img/zumba.png',2),
        (3,'Yoga','Relajación, flexibilidad y respiración.','img/yoga.png',3),
        (4,'Boxeo','Técnicas de boxeo para cardio y coordinación.','img/boxeo.png',4)");

    $hash = password_hash('admin', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO usuarios (username, password_hash, nombre, rol) VALUES ('webadmin', ?, 'Administrador', 'admin')");
    $stmt->execute([$hash]);

    echo "Base de datos creada o actualizada correctamente.";
} catch (PDOException $e) {
    die('Error al inicializar la base: ' . $e->getMessage());
}
?>