<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Notification {
    
    // Busca apenas as não lidas do usuário
    public static function getUnread($userId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = :u AND is_read = 0 ORDER BY created_at DESC");
        $stmt->bindValue(':u', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Cria uma nova (útil para quando o Lead se cadastra)
    public static function create($userId, $title, $msg) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, title, message) VALUES (:u, :t, :m)");
        $stmt->bindValue(':u', $userId);
        $stmt->bindValue(':t', $title);
        $stmt->bindValue(':m', $msg);
        return $stmt->execute();
    }

    // Marca todas como lidas (Limpar)
    public static function markAllRead($userId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :u");
        $stmt->bindValue(':u', $userId);
        return $stmt->execute();
    }
}