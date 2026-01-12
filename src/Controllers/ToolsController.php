<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class ToolsController extends Controller {
    
    public function bidAnalyst() {
        $user = User::getById(1); // Mantendo o Lucas logado
        $this->view('pages/admin/tools/bid_analyst', ['user' => $user]);
    }

    public function roiCalculator() {
        $user = User::getById(1);
        $this->view('pages/admin/tools/roi_investor', ['user' => $user]);
    }
    
    public function bidPdf() {
        $data = [
            'credit' => $_GET['credit'] ?? 0,
            'avg' => $_GET['avg'] ?? 0,
            'bid_val' => $_GET['bid_val'] ?? 0,
            'bid_pct' => $_GET['bid_pct'] ?? 0,
            'status' => $_GET['status'] ?? 'BAIXA',
            'diff' => $_GET['diff'] ?? 0,
            'notes' => $_GET['notes'] ?? '',
            'consultant' => \App\Models\User::getById($_SESSION['user_id'])
        ];

        ob_start();
        extract($data);
        include __DIR__ . '/../Views/pdf/bid_template.php';
        $html = ob_get_clean();

        require_once __DIR__ . '/../../vendor/autoload.php';
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Analise_Lances_GMR.pdf", ["Attachment" => false]);
    }
    
    public function investorPdf() {
        // 1. Captura os dados da URL (GET)
        $data = [
            'credit' => $_GET['credit'] ?? 0,
            'parcel' => $_GET['parcel'] ?? 0,
            'months' => $_GET['months'] ?? 0,
            'down' => $_GET['down'] ?? 0,
            'sale' => $_GET['sale'] ?? 0,
            'roi' => $_GET['roi'] ?? 0,
            'profit' => $_GET['profit'] ?? 0,
            'invested' => $_GET['invested'] ?? 0,
            'notes' => $_GET['notes'] ?? '',
            // Pega o usuário logado para o rodapé
            'consultant' => \App\Models\User::getById($_SESSION['user_id'])
        ];

        // 2. Carrega o Template HTML
        ob_start();
        extract($data); // Transforma o array em variáveis ($credit, $parcel...)
        include __DIR__ . '/../Views/pdf/investor_template.php';
        $html = ob_get_clean();

        // 3. Gera o PDF (Usando DomPDF)
        require_once __DIR__ . '/../../vendor/autoload.php';
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 4. Envia para o navegador
        $dompdf->stream("Estudo_Investimento_GMR.pdf", ["Attachment" => false]);
    }
}