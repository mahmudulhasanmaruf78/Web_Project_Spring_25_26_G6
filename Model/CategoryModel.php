<?php
require_once __DIR__ . '/../config/db.php';

class CategoryModel
{
    private $conn;

    public function __construct()
    {
        $db = new db();
        $this->conn = $db->connection();
    }

    public function addCategory($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories(name) VALUES(?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function getCategories()
    {
        return $this->conn->query("SELECT * FROM categories");
    }

    public function getCategoryById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateCategory($id, $name)
    {
        $stmt = $this->conn->prepare("UPDATE categories SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function checkJobs($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM jobs WHERE category_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->num_rows;
    }
}
?>
