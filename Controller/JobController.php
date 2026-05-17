<?php
session_start();

require_once '../Model/JobModel.php';

$model = new JobModel();

if(isset($_POST['create']))
{
    $eid = $_SESSION['user_id'];

    $category = trim($_POST['category_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $requirements = trim($_POST['requirements']);
    $salary = trim($_POST['salary']);
    $location = trim($_POST['location']);
    $type = trim($_POST['job_type']);
    $deadline = trim($_POST['deadline']);

    if(empty($title) || empty($description) || empty($requirements))
    {
        die("All fields required");
    }

    if(strtotime($deadline) < strtotime(date('Y-m-d')))
    {
        die("Deadline invalid");
    }

    $model->createJob(
        $eid,
        $category,
        $title,
        $description,
        $requirements,
        $salary,
        $location,
        $type,
        $deadline
    );

    header("Location: ../View/EmployerJobs.php");
}

if(isset($_POST['update']))
{
    $model->updateJob(
        $_POST['id'],
        $_POST['category_id'],
        $_POST['title'],
        $_POST['description'],
        $_POST['requirements'],
        $_POST['salary'],
        $_POST['location'],
        $_POST['job_type'],
        $_POST['deadline']
    );

    header("Location: ../View/EmployerJobs.php");
}

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    $model->deleteJob($id);

    header("Location: ../View/EmployerJobs.php");
}
?>
