<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Simulation {

    // 1. Cria nova simulação (CORRIGIDO: Incluindo 'type')
    public static function create($data) {
        $pdo = Database::getInstance();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Adicionei financing_term_months na lista e nos Values
        $sql = "INSERT INTO simulations (
                    lead_id, type, credit_value, term_months, financing_term_months, 
                    consortium_rate, bid_suggestion, consortium_total, consortium_parcel, 
                    financing_total, has_insurance
                ) VALUES (
                    :lead_id, :type, :credit, :months, :fin_months, 
                    :rate, :bid, :total_cons, :parcel_cons, 
                    :total_fin, :has_insurance
                )";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':lead_id', $data['lead_id']);
        $stmt->bindValue(':type', $data['type'] ?? 'imovel');
        $stmt->bindValue(':credit', $data['credit_value']);
        $stmt->bindValue(':months', $data['term_months']);
        
        // --- NOVO CAMPO ---
        // Se não vier definido, usa o mesmo prazo do consórcio como fallback
        $stmt->bindValue(':fin_months', $data['financing_term_months'] ?? $data['term_months']);
        
        $stmt->bindValue(':rate', $data['consortium_rate']);
        $stmt->bindValue(':bid', $data['bid_suggestion']);
        $stmt->bindValue(':total_cons', $data['consortium_total']);
        $stmt->bindValue(':parcel_cons', $data['consortium_parcel']);
        $stmt->bindValue(':total_fin', $data['financing_total']);
        
        $hasIns = (isset($data['has_insurance']) && ($data['has_insurance'] == true || $data['has_insurance'] == 1)) ? 1 : 0;
        $stmt->bindValue(':has_insurance', $hasIns);

        return $stmt->execute();
    }

    // 2. Busca recentes para o Dashboard
    public static function getRecent($limit = 5) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM simulations ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // 3. Estatísticas para o Dashboard
    // 3. Estatísticas para o Dashboard (Visão Geral)
    public static function getStats() {
        $pdo = Database::getInstance();
        
        // 1. Volume Total (PIPELINE): Soma apenas leads que estão "vivos" (new, proposal, analysis)
        // Ignora 'lost' (perdido) e 'closed' (já vendido/contabilizado na performance)
        $sqlVolume = "SELECT SUM(s.credit_value) 
                      FROM simulations s
                      JOIN leads l ON s.lead_id = l.id
                      WHERE l.status IN ('new', 'proposal', 'analysis')";
                      
        $totalVolume = $pdo->query($sqlVolume)->fetchColumn() ?: 0;
        
        // 2. Simulações feitas hoje (Mantém igual)
        $today = $pdo->query("SELECT COUNT(*) FROM simulations WHERE DATE(created_at) = CURDATE()")->fetchColumn() ?: 0;
        
        // 3. Total de Leads Ativos (Não conta os perdidos)
        $totalLeads = $pdo->query("SELECT COUNT(*) FROM leads WHERE status != 'lost'")->fetchColumn() ?: 0;

        return [
            'total_leads' => $totalLeads,
            'total_volume' => $totalVolume,
            'simulations_today' => $today
        ];
    }

    // 4. Busca simulações de um lead específico
    public static function getByLeadId($leadId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM simulations WHERE lead_id = :lead_id ORDER BY created_at DESC");
        $stmt->bindValue(':lead_id', $leadId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // 5. Deletar
    public static function delete($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM simulations WHERE id = :id");
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // 6. Busca por ID (Para o PDF)
    public static function getById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM simulations WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject();
    }
}