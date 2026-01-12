<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Performance;

class ReportController extends Controller {

    public function index() {
        if (!isset($_SESSION['user_id'])) header('Location: /login');

        $userId = $_SESSION['user_id'];
        $user = User::getById($userId);

        // Pega mês/ano da URL ou atual
        $month = $_GET['m'] ?? date('m');
        $year = $_GET['y'] ?? date('Y');
        $monthYear = "$year-$month";

        // 1. Métricas Manuais
        $manualMetrics = Performance::getMetrics($userId, $monthYear);

        // 2. Resultados Reais
        $realResults = Performance::getRealResults($userId, $month, $year);

        // 3. Cálculo de Comissão
        $commissionVal = ($realResults['sales_volume'] * ($user->commission_rate / 100));

        // ============================================================
        // 4. DADOS PARA O GRÁFICO DE TENDÊNCIA (Últimos 6 meses)
        // ============================================================
        $trendData = [];
        
        // Loop reverso: de 5 meses atrás até hoje (0)
        for ($i = 5; $i >= 0; $i--) {
            $d = new \DateTime();
            $d->modify("-$i months");
            $m = $d->format('m');
            $y = $d->format('Y');
            
            // Busca a performance daquele mês específico
            $res = Performance::getRealResults($userId, $m, $y);
            
            $trendData[] = [
                'label' => $d->format('M/y'), // Ex: Jan/26 (Rótulo do eixo X)
                'value' => $res['sales_volume'] // Ex: 150000.00 (Valor do eixo Y)
            ];
        }

        $this->view('pages/admin/performance', [
            'user' => $user,
            'manual' => $manualMetrics,
            'real' => $realResults,
            'commission' => $commissionVal,
            'month' => $month,
            'year' => $year,
            'trendData' => $trendData // <--- Nova variável passada para a View
        ]);
    }

    public function save() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (Performance::saveMetrics($_SESSION['user_id'], $data['month_year'], $data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    
    public function exportPdf() {
        // --- 1. PREPARAÇÃO DOS DADOS (Seu código original, que já sabemos que funciona) ---
        $userId = $_SESSION['user_id'];
        $userData = User::getById($userId);
        $user = is_array($userData) ? (object) $userData : $userData;

        $month = $_GET['m'] ?? date('m');
        $year = $_GET['y'] ?? date('Y');

        $real = Performance::getRealResults($userId, $month, $year);
        $commission = $real['sales_volume'] * ($user->commission_rate / 100);
        
        $manualData = Performance::getMetrics($userId, "$year-$month");
        if (!$manualData) {
            $manual = (object) ['calls_made'=>0, 'whatsapp_sent'=>0, 'video_calls'=>0, 'visits_made'=>0];
        } else {
            $manual = (object) $manualData;
        }

        $trendData = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = new \DateTime();
            $d->setDate($year, $month, 1); 
            $d->modify("-$i months");
            $m = $d->format('m');
            $y = $d->format('Y');
            $res = Performance::getRealResults($userId, $m, $y);
            $trendData[] = ['label' => $d->format('M/Y'), 'value' => $res['sales_volume']];
        }

        // --- 2. GERAÇÃO DO HTML ---
        $data = compact('user', 'month', 'year', 'real', 'commission', 'manual', 'trendData');
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/pdf/performance_template.php';
        $html = ob_get_clean();

        // --- 3. GERAÇÃO DO PDF (COM DIAGNÓSTICO DE ERRO) ---
        try {
            // Aumenta memória temporariamente para evitar estouro
            ini_set('memory_limit', '256M');

            // Verifica se o Autoload já carregou o DomPDF
            if (!class_exists('\Dompdf\Dompdf')) {
                // Tenta carregar manualmente caso o index.php não tenha pego
                if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
                    require_once __DIR__ . '/../../vendor/autoload.php';
                } else {
                    throw new \Exception("Arquivo vendor/autoload.php não encontrado. Você rodou 'composer require dompdf/dompdf'?");
                }
            }

            // Verifica novamente após o require
            if (!class_exists('\Dompdf\Dompdf')) {
                throw new \Exception("A classe Dompdf não foi encontrada. Verifique se a biblioteca está instalada na pasta vendor.");
            }

            $dompdf = new \Dompdf\Dompdf();
            
            // Configurações Críticas
            $options = $dompdf->getOptions();
            $options->set('isRemoteEnabled', true); // Permite imagens externas
            $options->set('chroot', realpath(__DIR__ . '/../../')); // Permite ler arquivos locais (CSS/Imagens)
            $dompdf->setOptions($options);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            $filename = "Performance_Lucas.pdf";
            $dompdf->stream($filename, ["Attachment" => false]);

        } catch (\Throwable $e) {
            // IMPRIME O ERRO NA TELA
            echo "<div style='background: #ffebee; color: #c62828; padding: 20px; font-family: sans-serif; border: 1px solid #ef9a9a; border-radius: 5px; margin: 20px;'>";
            echo "<h2 style='margin-top:0'>🛑 Erro Fatal no PDF</h2>";
            echo "<p><strong>O que aconteceu:</strong> " . $e->getMessage() . "</p>";
            echo "<p><strong>Arquivo:</strong> " . $e->getFile() . " (Linha: " . $e->getLine() . ")</p>";
            echo "<hr style='border: 0; border-top: 1px solid #ef9a9a;'>";
            echo "<h3 style='font-size: 14px;'>Rastreamento (Stack Trace):</h3>";
            echo "<pre style='background: #fff; padding: 10px; overflow: auto;'>" . $e->getTraceAsString() . "</pre>";
            echo "</div>";
            exit;
        }
    }

    // Geração do Excel/CSV
    public function export() {
        $userId = $_SESSION['user_id'];
        $month = $_GET['m'];
        $year = $_GET['y'];
        $monthYear = "$year-$month";

        $user = User::getById($userId);
        $manual = Performance::getMetrics($userId, $monthYear);
        $real = Performance::getRealResults($userId, $month, $year);
        $comissao = ($real['sales_volume'] * ($user->commission_rate / 100));

        // Nome do arquivo
        $filename = "Relatorio_Performance_" . $user->name . "_$month-$year.csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Cria o arquivo na memória
        $output = fopen('php://output', 'w');
        
        // BOM para o Excel ler acentos corretamente
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Cabeçalho
        fputcsv($output, ['RELATÓRIO DE PERFORMANCE MENSAL - GMR']);
        fputcsv($output, ['Consultor', $user->name]);
        fputcsv($output, ['Período', "$month/$year"]);
        fputcsv($output, []); // Linha vazia

        // Atividades
        fputcsv($output, ['--- ATIVIDADES (FUNIL) ---']);
        fputcsv($output, ['Ligações Feitas', $manual->calls_made]);
        fputcsv($output, ['Mensagens WhatsApp', $manual->whatsapp_sent]);
        fputcsv($output, ['Vídeo Chamadas', $manual->video_calls]);
        fputcsv($output, ['Visitas Presenciais', $manual->visits_made]);
        fputcsv($output, []);

        // Resultados
        fputcsv($output, ['--- RESULTADOS ---']);
        fputcsv($output, ['Vendas Fechadas', $real['sales_count']]);
        fputcsv($output, ['Volume Total (VGP)', number_format($real['sales_volume'], 2, ',', '.')]);
        fputcsv($output, ['Comissão Estimada', number_format($comissao, 2, ',', '.')]);
        fputcsv($output, []);

        // Status
        fputcsv($output, ['--- DETALHE DO PIPELINE ---']);
        foreach($real['status_breakdown'] as $status => $count) {
            fputcsv($output, [strtoupper($status), $count]);
        }

        fclose($output);
        exit;
    }
}