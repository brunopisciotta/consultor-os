<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Simulation;
use App\Models\Lead;

class SimulatorController extends Controller {

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . \App\Config\Config::BASE_URL . '/login');
            exit;
        }

        $user = User::getById($_SESSION['user_id']);
        $leads = Lead::getAll(); 

        $this->view('pages/admin/simulator', [
            'user' => $user,
            'leads' => $leads
        ]);
    }

    public function save() {
        // Habilita exibição de erros temporariamente para debug
        ini_set('display_errors', 0); // Desliga output direto para não quebrar o JSON
        header('Content-Type: application/json');

        try {
            // 1. Recebe o JSON
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            // 2. Validação Básica
            if (!$data || !isset($data['lead_id']) || empty($data['lead_id'])) {
                throw new \Exception('ID do Lead não foi enviado ou está vazio.');
            }

            // 3. Tenta salvar (Se der erro no SQL, vai cair no catch abaixo)
            if (Simulation::create($data)) {
                echo json_encode(['status' => 'success']);
            } else {
                throw new \Exception('O banco de dados recusou a gravação (retornou false).');
            }

        } catch (\PDOException $e) {
            // Erro de Banco de Dados (SQL)
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 
                'message' => 'Erro SQL: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            // Erro Genérico
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 
                'message' => 'Erro: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete() {
        header('Content-Type: application/json');
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (isset($data['id'])) {
            $pdo = \App\Config\Database::getInstance();
            $stmt = $pdo->prepare("DELETE FROM simulations WHERE id = :id");
            $stmt->bindValue(':id', $data['id']);
            
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}