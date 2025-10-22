<?php
// public/index.php - PUNTO DE ENTRADA PRINCIPAL
session_start();

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

// Incluir todos los controllers
require_once __DIR__ . '/../app/controllers/ActividadesController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/TiposController.php';

// Obtener la acción desde GET
$action = $_GET['action'] ?? 'home';

// Routing principal
switch ($action) {
    case 'home':
    case '':
        $controller = new ActividadesController($pdo);
        $controller->index();
        break;
        
    case 'actividades':
        $controller = new ActividadesController($pdo);
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->view($id);
        } else {
            $controller->index();
        }
        break;
        
    case 'tipos':
        $controller = new TiposController($pdo);
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->view($id);
        } else {
            $controller->index();
        }
        break;
        
    case 'tipo':  // Para compatibilidad con tus vistas
        $controller = new TiposController($pdo);
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->view($id);
        } else {
            header('Location: ' . BASE_URL . '?action=tipos');
            exit;
        }
        break;
        
    case 'login':
        $controller = new AuthController($pdo);
        $controller->login();
        break;
        
    case 'logout':
        $controller = new AuthController($pdo);
        $controller->logout();
        break;
        
    case 'admin':
        $controller = new AdminController($pdo);
        $controller->handle(
            $_GET['op'] ?? 'dashboard',
            $_GET['subject'] ?? null,
            $_GET['id'] ?? null
        );
        break;
        
    default:
        http_response_code(404);
        echo 'Página no encontrada - ' . htmlspecialchars($action);
        break;
}
?>