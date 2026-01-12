<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Lead;
use App\Models\Simulation;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProposalController extends Controller {
    
    public function generate() {
        // 1. Pega o ID da Simulação
        $simId = $_GET['sim_id'] ?? null;
        if (!$simId) die("Simulação não encontrada.");

        // 2. Busca os dados no Banco
        // Precisamos criar um método no Model para pegar UMA simulação pelo ID
        $simulation = Simulation::getById($simId);
        if (!$simulation) die("Simulação não existe.");

        $lead = Lead::getById($simulation->lead_id);

        // 3. Configura o DomPDF
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite carregar imagens externas se precisar
        $dompdf = new Dompdf($options);

        // 4. Carrega o HTML do PDF (Passando os dados)
        // Usamos ob_start para capturar o HTML da view em vez de imprimi-lo
        ob_start();
        extract(['lead' => $lead, 'sim' => $simulation]);
        require __DIR__ . '/../Views/pdf/template.php';
        $html = ob_get_clean();

        // 5. Renderiza e Baixa
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Gera o nome do arquivo: Proposta_Bruno_Pisciotta.pdf
        $filename = 'Proposta_' . str_replace(' ', '_', $lead->name) . '.pdf';
        
        // Envia para o navegador (Stream = Baixar/Abrir)
        $dompdf->stream($filename, ["Attachment" => false]); // false = Abre no navegador, true = Baixa direto
    }
}