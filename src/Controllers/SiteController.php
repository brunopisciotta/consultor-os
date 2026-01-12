<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Lead;
use App\Models\Simulation;
use App\Models\User;

class SiteController extends Controller {

    public function index() {
        // BUSCA O CONSULTOR PARA PERSONALIZAR A PÁGINA (Nome e Foto)
        $consultant = User::getById(1);

        // Envia para a view com o nome 'user' para bater com a lógica do home.php
        $this->view('pages/site/home', ['user' => $consultant]);
    }

    public function registerLead() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) $input = $_POST;

        try {
            if (empty($input['name']) || empty($input['phone'])) {
                throw new \Exception('Nome e Telefone são obrigatórios.');
            }

            // 1. Cria o Lead
            $leadData = [
                'name' => filter_var($input['name'], FILTER_SANITIZE_STRING),
                'email' => filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL),
                'phone' => filter_var($input['phone'], FILTER_SANITIZE_STRING),
                'objective' => $input['objective'] ?? 'investimento',
                
                // --- NOVOS CAMPOS ADICIONADOS ---
                'message' => filter_var($input['message'] ?? '', FILTER_SANITIZE_STRING), // Captura a mensagem/dor do cliente
                'origin' => 'landing_page', // Rastreia de onde veio o lead
                // --------------------------------
                
                'status' => 'new'
            ];
            
            if (!Lead::create($leadData)) {
                throw new \Exception('Erro ao cadastrar contato.');
            }

            $pdo = \App\Config\Database::getInstance();
            $leadId = $pdo->lastInsertId();

            // 2. Cria a Simulação Automática se houver dados
            if (!empty($input['credit'])) {
                $admin = User::getById(1);
                $taxaAdm = $admin->default_consortium_rate ?? 22.00;
                $taxaFin = $admin->default_financing_rate ?? 10.50;

                $credito = floatval($input['credit']);
                $prazo = intval($input['term'] ?? 200);

                // Cálculos
                $totalConsorcio = $credito * (1 + ($taxaAdm / 100));
                $parcelaConsorcio = $totalConsorcio / $prazo;

                $taxaMensalFin = pow(1 + ($taxaFin / 100), 1/12) - 1;
                $pmtFin = $credito * ($taxaMensalFin * pow(1 + $taxaMensalFin, $prazo)) / (pow(1 + $taxaMensalFin, $prazo) - 1);
                $totalFinanciamento = $pmtFin * $prazo;

                $simData = [
                    'lead_id' => $leadId,
                    'type' => $input['type'] ?? 'imovel',
                    'credit_value' => $credito,
                    'term_months' => $prazo,
                    'consortium_rate' => $taxaAdm,
                    'bid_suggestion' => 0,
                    'consortium_parcel' => $parcelaConsorcio,
                    'consortium_total' => $totalConsorcio,
                    'financing_total' => $totalFinanciamento,
                    'has_insurance' => 0
                ];

                Simulation::create($simData);
            }

            echo json_encode(['status' => 'success', 'message' => 'Simulação recebida!']);

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}