<?php
class ActividadesController {
    private $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }
    public function index(){
        $stmt = $this->pdo->query("SELECT a.id,a.nombre,a.imagen,t.nombre AS tipo FROM actividades a LEFT JOIN tipos t ON a.tipo_id=t.id ORDER BY a.created_at DESC");
        $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__.'/../views/layout/header.phtml';
        require __DIR__.'/../views/actividades/index.phtml';
        require __DIR__.'/../views/layout/footer.phtml';
    }
    public function view($id){
        if (!$id) { header('Location: ' . BASE_URL); exit; }
        $stmt = $this->pdo->prepare("SELECT a.*, t.nombre AS tipo FROM actividades a LEFT JOIN tipos t ON a.tipo_id=t.id WHERE a.id = ?");
        $stmt->execute([$id]);
        $actividad = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$actividad) { echo 'Actividad no encontrada'; return; }
        require __DIR__.'/../views/layout/header.phtml';
        require __DIR__.'/../views/actividades/view.phtml';
        require __DIR__.'/../views/layout/footer.phtml';
    }
}
?>