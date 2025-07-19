<?php

require_once __DIR__ . '/../Config/Database.php';

class User
{
    private $conn;
    private $table = "users";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function register($username, $password)
{
    $role = (preg_match('/^adminbuku[0-9]+$/', $username)) ? 'admin' : 'user';
    $query = "INSERT INTO " . $this->table . " (username, password, role) VALUES (:username, :password, :role)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $hashed);
    $stmt->bindParam(':role', $role);
    return $stmt->execute();
}


    public function login($username, $password)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}

