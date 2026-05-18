<?php
require_once 'db.php';

class CategoryModel
{
    private $conn;

    // Connect to database
    public function __construct()
    {
        $db = new db();
        $this->conn = $db->connection();
    }

    // Add new category
    public function addCategory($name)
    {
        $sql = "INSERT INTO categories(name) VALUES(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    // Get all categories
    public function getCategories()
    {
        $sql = "SELECT * FROM categories";
        return $this->conn->query($sql);
    }

    // Get category by ID
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Update category
    public function updateCategory($id, $name)
    {
        $sql = "UPDATE categories SET name=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    // Delete category
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM categories WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Check if jobs exist in this category
    public function checkJobs($id)
    {
        $sql = "SELECT * FROM jobs WHERE category_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->num_rows; // number of jobs
    }
}
?>
