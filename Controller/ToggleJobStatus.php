<?php
header('Content-Type: application/json');

require_once '../Model/JobModel.php';

$model = new JobModel();

if(isset($_POST['job_id']))
{
    $id = $_POST['job_id'];

    if($model->toggleStatus($id))
    {
        echo json_encode([
            'success' => true
        ]);
    }
    else
    {
        echo json_encode([
            'success' => false
        ]);
    }
}
?>
