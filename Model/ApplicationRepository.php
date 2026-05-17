<?php
class ApplicationRepository
{
    private mysqli $conn;
    function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    function getApplicationsByJob(int $jobId, int $employerId): array
    {
        $sql = "SELECT applications.id, applications.cover_letter, applications.resume_path, applications.status, 
                       applications.created_at, users.name, seeker_profiles.headline
                FROM applications
                JOIN users ON applications.seeker_id = users.id 
                JOIN seeker_profiles ON users.id = seeker_profiles.user_id
                JOIN jobs ON applications.job_id = jobs.id
                WHERE applications.job_id = ? AND jobs.employer_id = ?
                ORDER BY applications.created_at DESC";

        $results = $this->conn->prepare($sql);

        if (!$results) {
            throw new RuntimeException("Prepare failed: " . $this->conn->error);
        }

        $results->bind_param("ii", $jobId, $employerId);
        $results->execute();

        $applications = [];
        $result = $results->get_result();

        while ($row = $result->fetch_assoc()) {
            $applications[] = $row;
        }

        $results->close();
        return $applications;
    }

    function getChartDataByJob(int $jobId, int $employerId): array
    {
        $sql = "SELECT applications.status, COUNT(*) AS count
                FROM applications
                JOIN jobs ON applications.job_id = jobs.id
                WHERE applications.job_id = ? AND jobs.employer_id = ?
                GROUP BY applications.status";

        $results = $this->conn->prepare($sql);

        if (!$results) {
            throw new RuntimeException("Prepare failed: " . $this->conn->error);
        }

        $results->bind_param("ii", $jobId, $employerId);
        $results->execute();

        $chartData = ['Submitted' => 0, 'Reviewed' => 0, 'Shortlisted' => 0, 'Rejected' => 0];

        $result = $results->get_result();
        while ($row = $result->fetch_assoc()) {
            $chartData[$row['status']] = (int) $row['count'];
        }

        $results->close();
        return $chartData;
    }

    function updateApplicationStatus(int $appId, string $newStatus, int $employerId): bool
    {
        $sql = "UPDATE applications
                JOIN jobs ON applications.job_id = jobs.id
                SET applications.status = ?
                WHERE applications.id = ? AND jobs.employer_id = ?";

        $results = $this->conn->prepare($sql);

        if (!$results) {
            throw new RuntimeException("Prepare failed: " . $this->conn->error);
        }

        $results->bind_param("sii", $newStatus, $appId, $employerId);
        $results->execute();

        $success = ($results->affected_rows > 0 || $results->errno === 0);
        $results->close();

        return $success;
    }
}
