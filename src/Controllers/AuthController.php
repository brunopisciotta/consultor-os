<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {

    public function login() {
        // Se já estiver logado, joga pro Dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . \App\Config\Config::BASE_URL . '/dashboard');
            exit;
        }
        $this->view('pages/auth/login');
    }

    public function auth() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // 1. Busca o usuário pelo e-mail
        $user = User::findByEmail($email);

        // 2. Verifica se o usuário existe E se a senha bate com o Hash
        if ($user && password_verify($password, $user->password)) {
            
            // SUCESSO: Cria a sessão
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_avatar'] = $user->avatar;

            header('Location: ' . \App\Config\Config::BASE_URL . '/dashboard');
            exit;

        } else {
            // ERRO: Volta pro login com aviso
            header('Location: ' . \App\Config\Config::BASE_URL . '/login?error=invalid');
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . \App\Config\Config::BASE_URL . '/');
        exit;
    }
}