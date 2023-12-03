<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'userhelper.php';
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
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
        $stmt->execute([$database]);
        if ($stmt->rowCount() == 0){
            $pdo->exec("CREATE DATABASE `$database`");
            $pdo->exec("USE `$database`");
            $customInitScript = file_get_contents(__DIR__ . '/database/schema.sql');
            $pdo->exec($customInitScript);
            $this->connection = $pdo;

        } else {
            $pdo->exec("USE `$database`");
            $this->connection = $pdo;
        }

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
// $dbInstance = Database::getInstance();
// $_SESSION['db'] = $dbInstance;
?>
