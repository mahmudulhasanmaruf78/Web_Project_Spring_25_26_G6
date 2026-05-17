<?php
session_start();

include "../config/db.php";
include "../Model/ApplicationRepository.php";

header('Content-Type: application/json');

class UpdateStatusController
{
    private const ALLOWED_STATUSES = ['Submitted', 'Reviewed', 'Shortlisted', 'Rejected'];

    private function authorizeEmployer(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
            exit;
        }
    }

    public function handle(): void
    {
        $this->authorizeEmployer();

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id'], $input['status'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing application ID or status.']);
            return;
        }

        $appId      = (int)    $input['id'];
        $newStatus  = (string) $input['status'];
        $employerId = (int)    $_SESSION['user_id'];

        if (!in_array($newStatus, self::ALLOWED_STATUSES, true)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid status value.']);
            return;
        }

        try {
            $dbObj = new db();
            $conn  = $dbObj->connection();

            $repo    = new ApplicationRepository($conn);
            $success = $repo->updateApplicationStatus($appId, $newStatus, $employerId);

            $conn->close();

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Update failed or no changes made.']);
            }
        } catch (RuntimeException $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }
}

(new UpdateStatusController())->handle();
