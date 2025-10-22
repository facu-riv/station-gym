<?php
class AdminController {
    private $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }
    private function ensureAdmin(){
        if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . 'login'); exit; }
    }
    public function handle($op='dashboard', $subject=null, $id=null){
        $this->ensureAdmin();
        require __DIR__.'/../views/layout/header.phtml';
        if ($op === 'dashboard') {
            require __DIR__.'/../views/admin/dashboard.phtml';
        } elseif ($op === 'list' && $subject === 'actividades') {
            $stmt = $this->pdo->query("SELECT a.id,a.nombre,a.imagen,t.nombre AS tipo FROM actividades a LEFT JOIN tipos t ON a.tipo_id=t.id ORDER BY a.created_at DESC");
            $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
            require __DIR__.'/../views/admin/actividades_list.phtml';
        } elseif ($op === 'create' && $subject === 'actividad') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = $_POST['nombre'] ?? '';
                $descripcion = $_POST['descripcion'] ?? '';
                $tipo_id = $_POST['tipo_id'] ?: null;
                $imagen = $_POST['imagen'] ?: null;
                $stmt = $this->pdo->prepare("INSERT INTO actividades (nombre,descripcion,imagen,tipo_id) VALUES (?,?,?,?)");
                $stmt->execute([$nombre,$descripcion,$imagen,$tipo_id]);
                header('Location: ' . BASE_URL . 'admin?op=list&subject=actividades'); exit;
            }
            $tipos = $this->pdo->query("SELECT * FROM tipos ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
            require __DIR__.'/../views/admin/actividad_form.phtml';
        } elseif ($op === 'edit' && $subject === 'actividad') {
            if (!$id) { echo 'ID requerido'; return; }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = $_POST['nombre'] ?? '';
                $descripcion = $_POST['descripcion'] ?? '';
                $tipo_id = $_POST['tipo_id'] ?: null;
                $imagen = $_POST['imagen'] ?: null;
                $stmt = $this->pdo->prepare("UPDATE actividades SET nombre=?, descripcion=?, imagen=?, tipo_id=? WHERE id=?");
                $stmt->execute([$nombre,$descripcion,$imagen,$tipo_id,$id]);
                header('Location: ' . BASE_URL . 'admin?op=list&subject=actividades'); exit;
            }
            $stmt = $this->pdo->prepare("SELECT * FROM actividades WHERE id = ?"); $stmt->execute([$id]); $actividad = $stmt->fetch(PDO::FETCH_ASSOC);
            $tipos = $this->pdo->query("SELECT * FROM tipos ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
            require __DIR__.'/../views/admin/actividad_form.phtml';
        } elseif ($op === 'delete' && $subject === 'actividad') {
            if ($id) { $stmt = $this->pdo->prepare("DELETE FROM actividades WHERE id = ?"); $stmt->execute([$id]); }
            header('Location: ' . BASE_URL . 'admin?op=list&subject=actividades'); exit;
        } elseif ($op === 'list' && $subject === 'tipos') {
            $tipos = $this->pdo->query("SELECT * FROM tipos ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
            require __DIR__.'/../views/admin/tipos_list.phtml';
        } elseif ($op === 'create' && $subject === 'tipo') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = $_POST['nombre'] ?? '';
                $stmt = $this->pdo->prepare("INSERT INTO tipos (nombre) VALUES (?)"); $stmt->execute([$nombre]);
                header('Location: ' . BASE_URL . 'admin?op=list&subject=tipos'); exit;
            }
            require __DIR__.'/../views/admin/tipo_form.phtml';
        } elseif ($op === 'edit' && $subject === 'tipo') {
            if (!$id) { echo 'ID requerido'; return; }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = $_POST['nombre'] ?? '';
                $stmt = $this->pdo->prepare("UPDATE tipos SET nombre = ? WHERE id = ?"); $stmt->execute([$nombre,$id]);
                header('Location: ' . BASE_URL . 'admin?op=list&subject=tipos'); exit;
            }
            $stmt = $this->pdo->prepare("SELECT * FROM tipos WHERE id = ?"); $stmt->execute([$id]); $tipo = $stmt->fetch(PDO::FETCH_ASSOC);
            require __DIR__.'/../views/admin/tipo_form.phtml';
        } elseif ($op === 'delete' && $subject === 'tipo') {
            if ($id) { $stmt = $this->pdo->prepare("DELETE FROM tipos WHERE id = ?"); $stmt->execute([$id]); }
            header('Location: ' . BASE_URL . 'admin?op=list&subject=tipos'); exit;
        } else {
            echo '<p>Acción admin no encontrada.</p>';
        }
        require __DIR__.'/../views/layout/footer.phtml';
    }
}
?>