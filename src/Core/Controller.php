<?php
namespace App\Core;

class Controller {
    // Método para carregar as views (HTML)
    protected function view($viewName, $data = []) {
        // Extrai os dados para variáveis soltas (ex: ['nome' => 'Lucas'] vira $nome)
        extract($data);
        
        // Carrega o arquivo da view
        require __DIR__ . "/../Views/{$viewName}.php";
    }

    // Método para redirecionar
    protected function redirect($url) {
        header("Location: " . \App\Config\Config::BASE_URL . $url);
        exit;
    }
}