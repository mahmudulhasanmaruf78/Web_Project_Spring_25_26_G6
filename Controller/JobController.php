<?php
session_start();

require_once '../Model/JobModel.php';

$model = new JobModel();

if(isset($_POST['create']))
{
    $eid = $_SESSION['user_id'];

    $model->createJob(
        $eid,
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
