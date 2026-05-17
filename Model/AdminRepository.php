<?php
class AdminRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getSummaryStats(): array
    {
        // Total jobs
        $jobsResult = $this->conn->query("SELECT COUNT(*) as total FROM jobs");
        $totalJobs = $jobsResult->fetch_assoc()['total'];

        // Total applications
        $appsResult = $this->conn->query("SELECT COUNT(*) as total FROM applications");
        $totalApps = $appsResult->fetch_assoc()['total'];

        // Category summary
        $sql = "SELECT c.name AS category_name, COUNT(a.id) AS application_count 
                FROM categories c 
                LEFT JOIN jobs j ON c.id = j.category_id 
                LEFT JOIN applications a ON j.id = a.job_id 
                GROUP BY c.id";

        $categoryResult = $this->conn->query($sql);
        $categorySummary = [];
        while ($row = $categoryResult->fetch_assoc()) {
            $categorySummary[] = $row;
        }

        return [
            'total_jobs' => (int) $totalJobs,
            'total_apps' => (int) $totalApps,
            'category_summary' => $categorySummary
        ];
    }

    public function getGlobalJobs(string $categoryId, string $status): array
    {
        $sql = "SELECT j.id, j.title, j.status, c.name as category_name, ep.company_name 
                FROM jobs j
                LEFT JOIN categories c ON j.category_id = c.id
                LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
                WHERE 1=1";

        $params = [];
        $types = "";

        if ($categoryId !== '') {
            $sql .= " AND j.category_id = ?";
            $params[] = $categoryId;
            $types .= "i";
        }
        if ($status !== '') {
            $sql .= " AND j.status = ?";
            $params[] = $status;
            $types .= "s";
        }

        $sql .= " ORDER BY j.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();

        $result = $stmt->get_result();
        $jobs = [];
        while ($row = $result->fetch_assoc()) {
            $jobs[] = $row;
        }

        $stmt->close();
        return $jobs;
    }

    public function closeJob(int $jobId): bool
    {
        $sql = "UPDATE jobs SET status = 'closed' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $jobId);
        $stmt->execute();

        $success = ($stmt->errno === 0);
        $stmt->close();

        return $success;
    }
}
