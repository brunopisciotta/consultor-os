<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Lead;
use App\Models\Simulation;
use App\Models\User; // 1. IMPORTAÇÃO ADICIONADA
use App\Models\Notification;

class LeadController extends Controller {
    
    public function index() {
        // --- TRAVA DE SEGURANÇA ---
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . \App\Config\Config::BASE_URL . '/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Lead::create($_POST);
            Notification::create(1, 'Novo Lead!', 'Um novo cliente chegou via Site.');
            header('Location: leads');
            exit;
        }

        // 2. BUSCA O USUÁRIO (Igual à DashController)
        $user = User::getById(1);
        $leads = Lead::getAll();
        
        // 3. ENVIA O USUÁRIO PARA A VIEW
        $this->view('pages/admin/leads', [
            'user' => $user, 
            'leads' => $leads
        ]);
    }

    // Recebe o POST do Modal de Edição
   public function update() {
        // Verifica se é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Pega o ID (pode vir do POST ou JSON)
            $id = $_POST['id'] ?? null;
            
            if (!$id) {
                // Se não tiver ID, redireciona com erro (ou trata como quiser)
                header('Location: ' . \App\Config\Config::BASE_URL . '/leads');
                exit;
            }

            // Prepara os dados
            $data = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'objective' => $_POST['objective'],
                'status' => $_POST['status'], // CRUCIAL: Receber o status do formulário
                'message' => $_POST['message'] ?? '' // Opcional
            ];

            // Chama o Model
            if (\App\Models\Lead::update($id, $data)) {
                // Sucesso: Volta para a página de detalhes
                header('Location: ' . \App\Config\Config::BASE_URL . '/leads/details?id=' . $id);
                exit;
            } else {
                // Erro (pode adicionar uma mensagem de sessão aqui se quiser)
                header('Location: ' . \App\Config\Config::BASE_URL . '/leads/details?id=' . $id . '&error=true');
                exit;
            }
        }
    }

    // Recebe a chamada AJAX para Deletar
    public function delete() {
        // Pega o ID da URL (?id=2)
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            Lead::delete($id);
            header('Location: ' . \App\Config\Config::BASE_URL . '/leads');
            exit;
        }
    }

    public function details() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ../leads');
            exit;
        }

        // 2. BUSCA O USUÁRIO AQUI TAMBÉM (Para a tela de detalhes)
        $user = User::getById(1);
        $lead = Lead::getById($id);
        $simulations = Simulation::getByLeadId($id);

        if (!$lead) {
            echo "Cliente não encontrado.";
            exit;
        }

        // 3. ENVIA O USUÁRIO PARA A VIEW DE DETALHES
        $this->view('pages/admin/lead_details', [
            'user' => $user,
            'lead' => $lead, 
            'simulations' => $simulations
        ]);
    }
}