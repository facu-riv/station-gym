<?php
class AuthController {
    private $pdo;
    
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    
    public function login(){
        // Si ya está logueado, redirigir al admin
        if (!empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?action=admin');
            exit;
        }
        
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Usuario hardcodeado para pruebas (como pide el TP)
            if ($username === 'webadmin' && $password === 'admin') {
                $_SESSION['user'] = [
                    'id' => 1,
                    'username' => 'webadmin',
                    'rol' => 'admin'
                ];
                header('Location: ' . BASE_URL . '?action=admin');
                exit;
            }
            
            // Buscar en BD
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'rol' => $user['rol']
                ];
                header('Location: ' . BASE_URL . '?action=admin');
                exit;
            } else {
                $error = 'Usuario o contraseña incorrectos.';
            }
        }
        
        require __DIR__.'/../views/layout/header.phtml';
        require __DIR__.'/../views/auth/login.phtml';
        require __DIR__.'/../views/layout/footer.phtml';
    }
    
    public function logout(){
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }
}
?>