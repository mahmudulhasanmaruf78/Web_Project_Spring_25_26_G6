<?php
class JobRepository
{
    private mysqli $conn;

    function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    function getActiveJobsByEmployer(int $employerId): array
    {
        $sql = "SELECT id, title FROM jobs WHERE employer_id = ? AND status = 'active' ORDER BY created_at DESC";
        $results = $this->conn->prepare($sql);

        if (!$results) {
            throw new RuntimeException("Prepare failed: " . $this->conn->error);
        }

        $results->bind_param("i", $employerId);
        $results->execute();

        $jobs   = [];
        $result = $results->get_result();
        while ($row = $result->fetch_assoc()) {
            $jobs[] = $row;
        }

        $results->close();
        return $jobs;
    }
}
?>