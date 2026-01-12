<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Lead {
    // Busca todos os leads ordenados pelos mais recentes
    public static function getAll() {
        $pdo = Database::getInstance();
        // Ordena pelos mais recentes primeiro
        $stmt = $pdo->query("SELECT * FROM leads ORDER BY created_at DESC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    // Cria um novo lead
    // No método create($data):
    public static function create($data) {
        $pdo = Database::getInstance();
        // Adicionei 'message' na query
        $stmt = $pdo->prepare("INSERT INTO leads (consultant_id, name, email, phone, objective, message, status, origin) VALUES (:consultant_id, :name, :email, :phone, :objective, :message, 'new', :origin)");
        
        $stmt->bindValue(':consultant_id', 1); // ID fixo do Lucas por enquanto
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':objective', $data['objective']);
        
        // NOVO CAMPO:
        $stmt->bindValue(':message', $data['message'] ?? null);
        
        $stmt->bindValue(':origin', $data['origin'] ?? 'manual'); // Para saber se veio do site ou manual
        
        return $stmt->execute();
    }

    public static function getById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM leads WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Atualiza os dados de um lead
   // Atualiza os dados de um lead (Incluindo Status e Mensagem)
    public static function update($id, $data) {
        $pdo = Database::getInstance();
        
        $sql = "UPDATE leads SET 
                    name = :name, 
                    email = :email, 
                    phone = :phone, 
                    objective = :objective, 
                    status = :status,
                    message = :message 
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':objective', $data['objective']);
        
        // Status é crucial para a Performance
        $stmt->bindValue(':status', $data['status'] ?? 'new'); 
        
        // História do cliente
        $stmt->bindValue(':message', $data['message'] ?? null);
        
        $stmt->bindValue(':id', $id);
        
        return $stmt->execute();
    }

    // Exclui um lead
    public static function delete($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM leads WHERE id = :id");
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}