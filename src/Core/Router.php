<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // 1. Descobre a pasta onde o script físico está
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        
        // 2. CORREÇÃO CRÍTICA: Lidar com o .htaccess
        // Se a gente estiver rodando via .htaccess, a URL não tem '/public', 
        // mas o scriptName tem. Precisamos remover o '/public' do scriptName 
        // para a conta fechar.
        
        // Se a URL digitada NÃO começa com o caminho do script...
        if (strpos($uri, $scriptName) !== 0) {
            // ... e se o script estiver dentro da pasta public...
            if (str_ends_with($scriptName, '/public')) {
                // ... removemos o '/public' do caminho base
                $scriptName = substr($scriptName, 0, -7); // Remove os últimos 7 chars (/public)
            }
        }

        // 3. Remove a pasta base da URL
        if ($scriptName !== '/' && $scriptName !== '\\') {
            if (strpos($uri, $scriptName) === 0) {
                $uri = substr($uri, strlen($scriptName));
            }
        }

        // 4. Limpezas finais
        if ($uri === '' || $uri === false) $uri = '/';
        if ($uri !== '/' && substr($uri, -1) === '/') $uri = rtrim($uri, '/');

        // Verifica a rota
        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            $controllerName = $action[0]; 
            $methodName = $action[1];

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                } else {
                    echo "Erro: Método $methodName não encontrado.";
                }
            } else {
                echo "Erro: Classe $controllerName não encontrada.";
            }
        } else {
            http_response_code(404);
            // Debug visual para ajudar a entender o que está acontecendo
            echo "<div style='font-family: sans-serif; text-align: center; padding: 50px;'>";
            echo "<h1>Erro 404</h1>";
            echo "<p>Página não encontrada.</p>";
            echo "<p style='color: #888; font-size: 0.9em; margin-top: 20px;'>";
            echo "Rota calculada: <strong>$uri</strong><br>";
            echo "Base detectada: <strong>$scriptName</strong>";
            echo "</p></div>";
        }
    }
}