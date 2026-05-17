<?php
require_once __DIR__ . '/../config/db.php';

class JobModel
{
    private $conn;

    public function __construct()
    {
        $db = new db();
        $this->conn = $db->connection();
    }

    public function createJob($eid,$cid,$title,$description,$requirements,$salary,$location,$type,$deadline)
    {
        $stmt = $this->conn->prepare(
        "INSERT INTO jobs(employer_id,category_id,title,description,requirements,salary_range,location,job_type,deadline)
        VALUES(?,?,?,?,?,?,?,?,?)");

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

    public function getJobs($id)
    {
        $stmt = $this->conn->prepare(
        "SELECT jobs.*, categories.name AS category_name
        FROM jobs
        JOIN categories
        ON jobs.category_id = categories.id
        WHERE employer_id=?"
        );

        $stmt->bind_param("i",$id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getJobById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM jobs WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateJob($id,$cid,$title,$description,$requirements,$salary,$location,$type,$deadline)
    {
        $stmt = $this->conn->prepare(
        "UPDATE jobs
        SET category_id=?,
        title=?,
        description=?,
        requirements=?,
        salary_range=?,
        location=?,
        job_type=?,
        deadline=?
        WHERE id=?"
        );

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

    public function deleteJob($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM jobs WHERE id=?");
        $stmt->bind_param("i",$id);
        return $stmt->execute();
    }

    public function toggleStatus($id)
    {
        $stmt = $this->conn->prepare(
        "UPDATE jobs
        SET status = IF(status='active','closed','active')
        WHERE id=?"
        );

        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }
}
?>
