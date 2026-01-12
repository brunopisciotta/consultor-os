<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class SettingsController extends Controller {
    
    public function index() {
        // --- TRAVA DE SEGURANÇA ---
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . \App\Config\Config::BASE_URL . '/login');
            exit;
        }
        
        // Pega o usuário 1 (Lucas)
        $user = User::getById(1);
        $this->view('pages/admin/settings', ['user' => $user]);
    }

   public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Recupera dados atuais do usuário (para não perder o avatar antigo se não enviar um novo)
            $currentUser = User::getById(1);
            $avatarName = $currentUser->avatar;

            // 2. Verifica se enviou uma nova imagem
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $file = $_FILES['avatar'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                
                // Validação básica de segurança (apenas imagens)
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array(strtolower($ext), $allowed)) {
                    // Gera nome único: avatar_1_TIMESTAMP.jpg
                    $newName = 'avatar_1_' . time() . '.' . $ext;
                    $dest = __DIR__ . '/../../public/assets/img/' . $newName;
                    
                    if (move_uploaded_file($file['tmp_name'], $dest)) {
                        $avatarName = $newName; // Sucesso! Atualiza o nome para salvar no banco
                    }
                }
            }

            // 3. Prepara os dados para o Model
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'fin_rate' => $_POST['fin_rate'],
                'adm_rate' => $_POST['adm_rate'],
                'comm_rate' => $_POST['comm_rate'],
                'sales_goal' => $_POST['sales_goal'], // NOVO
                'avatar' => $avatarName
            ];

            User::update(1, $data);
            
            header('Location: ' . \App\Config\Config::BASE_URL . '/configuracoes?status=success');
        }
    }
}