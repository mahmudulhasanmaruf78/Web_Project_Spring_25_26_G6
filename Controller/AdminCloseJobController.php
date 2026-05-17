<?php
session_start();

include "../config/db.php";
include "../Model/AdminRepository.php";

header('Content-Type: application/json');

class AdminCloseJobController
{
    private function authorizeAdmin(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
            exit;
        }
    }

    public function handle(): void
    {
        $this->authorizeAdmin();

        // Decode the PUT request
        $input = json_decode(file_get_contents('php://input'), true);
        $jobId = $input['id'] ?? null;

        if (!$jobId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Job ID is required.']);
            return;
        }

        try {
            $dbObj = new db();
            $conn = $dbObj->connection();
            $repo = new AdminRepository($conn);

            $success = $repo->closeJob((int) $jobId);

            $conn->close();

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to close job or job already closed.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }
}

(new AdminCloseJobController())->handle();
