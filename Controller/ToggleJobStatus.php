<?php
session_start();

header('Content-Type: application/json');

require_once '../Model/JobModel.php';

$model = new JobModel();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['job_id']))
    {
        $id = $_POST['job_id'];

        if($model->toggleStatus($id))
        {
            echo json_encode([
                'success' => true,
                'message' => 'Status updated'
            ]);
        }
        else
        {
            echo json_encode([
                'success' => false,
                'message' => 'Database error'
            ]);
        }
    }
    else
    {
        echo json_encode([
            'success' => false,
            'message' => 'Job id missing'
        ]);
    }
}
?>
