<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Notification;

class NotificationController extends Controller {
    
    // API: Retorna JSON com as notificações
    public function list() {
        // ID fixo 1 (Lucas) por enquanto. Futuro: $_SESSION['user_id']
        $userId = 1; 
        $list = Notification::getUnread($userId);
        
        // Formata a data para "Há X tempo"
        foreach($list as $notif) {
            $notif->time_ago = $this->timeAgo($notif->created_at);
        }

        echo json_encode($list);
    }

    // API: Marca como lida
    public function read() {
        $userId = 1;
        Notification::markAllRead($userId);
        echo json_encode(['status' => 'success']);
    }

    // Auxiliar: Formata data amigável
    private function timeAgo($date) {
        $timestamp = strtotime($date);
        $diff = time() - $timestamp;
        
        if ($diff < 60) return "Agora mesmo";
        if ($diff < 3600) return floor($diff / 60) . " min atrás";
        if ($diff < 86400) return floor($diff / 3600) . " horas atrás";
        return date('d/m', $timestamp);
    }
}