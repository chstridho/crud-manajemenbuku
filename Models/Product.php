<?php

require_once __DIR__ . '/../Config/Database.php';

class Product
{
    private $conn;
    private $table = "products";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $author, $description)
    {
        $query = "UPDATE " . $this->table . " SET title = :title, author = :author, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cover', $cover);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function create($title, $author, $description, $cover = null)
{
    $query = "INSERT INTO " . $this->table . " (title, author, description, cover) VALUES (:title, :author, :description, :cover)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':cover', $cover);
    return $stmt->execute();
}

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}