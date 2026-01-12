<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class User {
    public static function getById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public static function findByEmail($email) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public static function update($id, $data) {
        $pdo = Database::getInstance();
        
        // Adicionei sales_goal na query
        $sql = "UPDATE users SET 
                    name = :name, 
                    email = :email, 
                    phone = :phone, 
                    avatar = :avatar,
                    default_financing_rate = :fin_rate,
                    default_consortium_rate = :adm_rate,
                    commission_rate = :comm_rate,
                    sales_goal = :sales_goal
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':avatar', $data['avatar']);
        $stmt->bindValue(':fin_rate', $data['fin_rate']);
        $stmt->bindValue(':adm_rate', $data['adm_rate']);
        $stmt->bindValue(':comm_rate', $data['comm_rate'] ?? 1.00);
        
        // NOVO CAMPO: Meta de Vendas (Padrão 100k)
        $stmt->bindValue(':sales_goal', $data['sales_goal'] ?? 100000.00);
        
        return $stmt->execute();
    }
    
    // Método para atualizar senha (opcional, mas bom ter)
    public static function updatePassword($id, $hash) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE users SET password = :p WHERE id = :id");
        $stmt->bindValue(':p', $hash);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}