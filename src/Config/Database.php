<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                // Conexão segura com UTF-8
                self::$instance = new PDO(
                    "mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME . ";charset=utf8mb4",
                    Config::DB_USER,
                    Config::DB_PASS
                );
                // Configura para lançar erros como Exceções (bom para debugar)
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                die("Erro de Conexão: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}