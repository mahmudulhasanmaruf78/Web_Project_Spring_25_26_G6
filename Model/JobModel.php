<?php
require_once '../config/db.php';

class JobModel
{
    private $conn;

    // Connect database
    public function __construct()
    {
        $this->conn = (new db())->connection();
    }

    // 1. Create a new job
    public function createJob($eid, $cid, $title, $description, $requirements, $salary, $location, $type, $deadline)
    {
        $sql = "INSERT INTO jobs 
        (employer_id, category_id, title, description, requirements, salary_range, location, job_type, deadline)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iisssssss",
            $eid,
            $cid,
            $title,
            $description,
            $requirements,
            $salary,
            $location,
            $type,
            $deadline
        );

        return $stmt->execute();
    }

    // 2. Get all jobs of a specific employer
    public function getJobs($eid)
    {
        $sql = "SELECT jobs.*, categories.name AS category_name
                FROM jobs
                JOIN categories ON jobs.category_id = categories.id
                WHERE employer_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $eid);
        $stmt->execute();

        return $stmt->get_result();
    }

    // 3. Get single job by ID
    public function getJobById($id)
    {
        $sql = "SELECT * FROM jobs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }

    // 4. Update job details
    public function updateJob($id, $cid, $title, $description, $requirements, $salary, $location, $type, $deadline)
    {
        $sql = "UPDATE jobs SET 
                category_id = ?,
                title = ?,
                description = ?,
                requirements = ?,
                salary_range = ?,
                location = ?,
                job_type = ?,
                deadline = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "isssssssi",
            $cid,
            $title,
            $description,
            $requirements,
            $salary,
            $location,
            $type,
            $deadline,
            $id
        );

        return $stmt->execute();
    }

    // 5. Delete a job
   public function deleteJob($id,$eid)
{
    $stmt = $this->conn->prepare(
    "DELETE FROM jobs WHERE id=? AND employer_id=?"
    );

    $stmt->bind_param("ii",$id,$eid);

    return $stmt->execute();
}


    // 6. Change job status (active <-> closed)
    public function toggleStatus($id)
    {
        $sql = "UPDATE jobs 
                SET status = IF(status = 'active', 'closed', 'active')
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
?>
