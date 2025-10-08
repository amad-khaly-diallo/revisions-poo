<?php
class ConnectDB
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private $pdo;

    public function __construct($host = 'localhost', $dbname = 'draft-shop', $username = 'root', $password = 'root', $charset = 'utf8mb4')
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $this->connect();
    }
    public function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            throw new Exception('Connection failed: ' . $e->getMessage());
        }
    }
}

try {
$db = new ConnectDB();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}