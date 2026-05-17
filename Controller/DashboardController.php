<?php
session_start();

include "../config/db.php";
include "../Model/JobRepository.php";

class DashboardController
{
    private string $warningMessage = "";
    private array $employerJobs = [];
    private int $employerId;

    public function __construct()
    {
        $this->authorizeUser();
        $this->employerId = (int) $_SESSION['user_id'];
    }

    function authorizeUser(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
            http_response_code(403);
            die("Unauthorized access. Please log in as an employer.");
        }
    }

    private function loadJobs(): void
    {
        $dbObj = new db();
        $conn = $dbObj->connection();

        if ($conn->connect_error) {
            throw new RuntimeException("Connection failed: " . $conn->connect_error);
        }

        $repo = new JobRepository($conn);
        $this->employerJobs = $repo->getActiveJobsByEmployer($this->employerId);

        $conn->close();
    }

    public function render(): void
    {
        try {
            $this->loadJobs();
        } catch (RuntimeException $e) {
            $this->warningMessage = "Database Error: " . $e->getMessage();
        }

        $viewData = [
            'warningMessage' => $this->warningMessage,
            'employerJobs' => $this->employerJobs,
        ];

        extract($viewData);
        require __DIR__ . '/../View/dashboard.view.php';
    }
}

// 3. Trigger the execution
(new DashboardController())->render();
