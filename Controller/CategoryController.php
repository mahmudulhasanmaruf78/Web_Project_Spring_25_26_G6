<?php
session_start();

require_once '../Model/CategoryModel.php';

$model = new CategoryModel();

/* =========================
   ADD CATEGORY
========================= */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {

    $name = trim($_POST['name']);

    if ($name == "") {
        die("Category name is required");
    }

    $model->addCategory($name);

    header("Location: ../View/CategoryList.php");
    exit();
}

/* =========================
   UPDATE CATEGORY
========================= */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];

    $model->updateCategory($id, $name);

    header("Location: ../View/CategoryList.php");
    exit();
}

/* =========================
   DELETE CATEGORY
========================= */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    // check if category has jobs
    $jobCount = $model->checkJobs($id);

    if ($jobCount > 0) {
        die("You cannot delete this category because it has jobs.");
    }

    $model->deleteCategory($id);

    header("Location: ../View/CategoryList.php");
    exit();
}
?>
