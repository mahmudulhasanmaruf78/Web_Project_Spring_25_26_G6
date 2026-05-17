<?php
session_start();

require_once '../Model/JobModel.php';

$model = new JobModel();

/* =========================
   CREATE JOB
========================= */
if (isset($_POST['create'])) {

    $employer_id = $_SESSION['user_id'];

    $model->createJob(
        $employer_id,
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
    exit();
}

/* =========================
   UPDATE JOB
========================= */
if (isset($_POST['update'])) {

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
    exit();
}

/* =========================
   DELETE JOB
========================= */
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    $eid = $_SESSION['user_id'];

    $model->deleteJob($id,$eid);

    header("Location: ../View/EmployerJobs.php");
}