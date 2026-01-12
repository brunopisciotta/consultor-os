<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Lead;
use App\Models\Simulation;
use App\Models\User;

class DashController extends Controller {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . \App\Config\Config::BASE_URL . '/login');
            exit;
        }
        
        // 1. Busca os dados consolidados
        $user = User::getById($_SESSION['user_id']);
        $stats = Simulation::getStats(); // Novo método de estatísticas
        $recentSimulations = Simulation::getRecent(5); // Novo método de simulações recentes
        $recentLeads = array_slice(Lead::getAll(), 0, 5);

        // 2. Envia para a View com as chaves que o novo dashboard.php espera
        $this->view('pages/admin/dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentSimulations' => $recentSimulations,
            'recent_leads' => $recentLeads
        ]);
    }
}