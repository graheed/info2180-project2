<?php
require __DIR__ . '/vendor/autoload.php';

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $database = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec("DROP DATABASE IF EXISTS `$database`");
        $pdo->exec("CREATE DATABASE `$database`");
        $pdo->exec("USE `$database`");

        $customInitScript = file_get_contents(__DIR__ . '/database/schema.sql');

        $pdo->exec($customInitScript);

        $this->connection = $pdo;
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
