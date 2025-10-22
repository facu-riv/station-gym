<?php
class TiposController {
    private $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }
    public function index(){
        $stmt = $this->pdo->query("SELECT * FROM tipos ORDER BY nombre");
        $tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__.'/../views/layout/header.phtml';
        require __DIR__.'/../views/tipos/index.phtml';
        require __DIR__.'/../views/layout/footer.phtml';
    }
    public function view($id){
        if (!$id) { header('Location: ' . BASE_URL . 'tipos'); exit; }
        $stmt = $this->pdo->prepare("SELECT * FROM tipos WHERE id = ?");
        $stmt->execute([$id]);
        $tipo = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt2 = $this->pdo->prepare("SELECT a.id,a.nombre,a.imagen FROM actividades a WHERE a.tipo_id = ? ORDER BY a.created_at DESC");
        $stmt2->execute([$id]);
        $actividades = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__.'/../views/layout/header.phtml';
        require __DIR__.'/../views/tipos/view.phtml';
        require __DIR__.'/../views/layout/footer.phtml';
    }
}
?>