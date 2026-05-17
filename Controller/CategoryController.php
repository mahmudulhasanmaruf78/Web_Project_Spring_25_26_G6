<?php
session_start();

require_once '../Model/CategoryModel.php';

$model = new CategoryModel();

if(isset($_POST['add']))
{
    $name = trim($_POST['name']);

    if(empty($name))
    {
        die("Category name required");
    }

    $model->addCategory($name);

    header("Location: ../View/CategoryList.php");
}

if(isset($_POST['update']))
{
    $id = $_POST['id'];
    $name = $_POST['name'];

    $model->updateCategory($id,$name);

    header("Location: ../View/CategoryList.php");
}

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    if($model->checkJobs($id) > 0)
    {
        die("Category has jobs");
    }

    $model->deleteCategory($id);

    header("Location: ../View/CategoryList.php");
}
?>
