<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Performance {

    // Busca ou cria as métricas manuais do mês
    public static function getMetrics($userId, $monthYear) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM performance_metrics WHERE user_id = :uid AND month_year = :my");
        $stmt->bindValue(':uid', $userId);
        $stmt->bindValue(':my', $monthYear);
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        // Se não existir, retorna um objeto zerado (não salva ainda pra não sujar o banco)
        if (!$data) {
            return (object) [
                'calls_made' => 0,
                'whatsapp_sent' => 0,
                'video_calls' => 0,
                'visits_made' => 0
            ];
        }
        return $data;
    }

    // Salva as métricas manuais
    public static function saveMetrics($userId, $monthYear, $data) {
        $pdo = Database::getInstance();
        
        // Upsert (Insere ou Atualiza)
        $sql = "INSERT INTO performance_metrics (user_id, month_year, calls_made, whatsapp_sent, video_calls, visits_made)
                VALUES (:uid, :my, :calls, :whats, :video, :visits)
                ON DUPLICATE KEY UPDATE
                calls_made = :calls, whatsapp_sent = :whats, video_calls = :video, visits_made = :visits";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uid', $userId);
        $stmt->bindValue(':my', $monthYear);
        $stmt->bindValue(':calls', $data['calls']);
        $stmt->bindValue(':whats', $data['whats']);
        $stmt->bindValue(':video', $data['video']);
        $stmt->bindValue(':visits', $data['visits']);
        
        return $stmt->execute();
    }

    // Busca os resultados reais (Leads vendidos, volume, etc)
    public static function getRealResults($userId, $month, $year) {
        $pdo = Database::getInstance();
        
        // Vendas (Status 'closed') no mês selecionado
        // ATENÇÃO: Consideramos a data de criação do lead ou você pode criar um campo 'closed_at' no futuro
        $sql = "SELECT 
                    COUNT(*) as total_sales,
                    SUM(s.credit_value) as total_volume
                FROM leads l
                LEFT JOIN simulations s ON l.id = s.lead_id
                WHERE l.consultant_id = :uid 
                AND l.status = 'closed'
                AND MONTH(l.created_at) = :m AND YEAR(l.created_at) = :y";
                
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uid', $userId);
        $stmt->bindValue(':m', $month);
        $stmt->bindValue(':y', $year);
        $stmt->execute();
        $sales = $stmt->fetch(PDO::FETCH_OBJ);

        // Contagem por status para o gráfico
        $sqlStatus = "SELECT status, COUNT(*) as total 
                      FROM leads 
                      WHERE consultant_id = :uid 
                      AND MONTH(created_at) = :m AND YEAR(created_at) = :y
                      GROUP BY status";
        $stmtStatus = $pdo->prepare($sqlStatus);
        $stmtStatus->bindValue(':uid', $userId);
        $stmtStatus->bindValue(':m', $month);
        $stmtStatus->bindValue(':y', $year);
        $stmtStatus->execute();
        $statusData = $stmtStatus->fetchAll(PDO::FETCH_KEY_PAIR); // Retorna ['new' => 10, 'closed' => 2]

        return [
            'sales_count' => $sales->total_sales ?? 0,
            'sales_volume' => $sales->total_volume ?? 0,
            'status_breakdown' => $statusData
        ];
    }
}