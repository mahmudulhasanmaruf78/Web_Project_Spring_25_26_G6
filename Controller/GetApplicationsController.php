<?php
session_start();

include "../config/db.php";
include "../Model/ApplicationRepository.php";

header('Content-Type: application/json');

class GetApplicationsController
{
    private function authorizeEmployer(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized access.']);
            exit;
        }
    }

    public function handle(): void
    {
        $this->authorizeEmployer();

        if (empty($_GET['job_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Job ID is missing.']);
            return;
        }

        $jobId = (int) $_GET['job_id'];
        $employerId = (int) $_SESSION['user_id'];

        try {
            $dbObj = new db();
            $conn = $dbObj->connection();

            $repo = new ApplicationRepository($conn);
            $applications = $repo->getApplicationsByJob($jobId, $employerId);

            $conn->close();

            echo json_encode($applications);
        } catch (RuntimeException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    }
}

(new GetApplicationsController())->handle();
