<?php
session_start();

include "../config/db.php";
include "../Model/AdminRepository.php";

header('Content-Type: application/json');

class AdminGetSummaryController
{
    private function authorizeAdmin(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized access.']);
            exit;
        }
    }

    public function handle(): void
    {
        $this->authorizeAdmin();

        try {
            $dbObj = new db();
            $conn = $dbObj->connection();
            $repo = new AdminRepository($conn);

            $stats = $repo->getSummaryStats();

            $conn->close();

            echo json_encode($stats);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    }
}

(new AdminGetSummaryController())->handle();
