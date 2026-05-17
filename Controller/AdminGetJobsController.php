<?php
session_start();
include "../config/db.php";
include "../Model/AdminRepository.php";

header('Content-Type: application/json');

class AdminGetJobsController
{
    public function handle(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(['error' => 'Unauthorized access.']);
            exit;
        }

        $categoryId = $_GET['category_id'] ?? '';
        $status = $_GET['status'] ?? '';

        try {
            $dbObj = new db();
            $conn = $dbObj->connection();
            $repo = new AdminRepository($conn);

            $jobs = $repo->getGlobalJobs($categoryId, $status);

            echo json_encode($jobs);
            $conn->close();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    }
}

(new AdminGetJobsController())->handle();
