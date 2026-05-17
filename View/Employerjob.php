<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: Login.php");
}

require_once '../Model/JobModel.php';

$model = new JobModel();

$jobs = $model->getJobs($_SESSION['user_id']);
?>

<a href="AddJob.php">Add Job</a>

<table border="1" cellpadding="10">

<tr>
<th>Title</th>
<th>Category</th>
<th>Deadline</th>
<th>Applications</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row=$jobs->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['category_name']; ?></td>

<td><?php echo $row['deadline']; ?></td>

<td><?php echo $row['total_applications']; ?></td>

<td>

<button
class="status-btn <?php echo $row['status']; ?>"
data-id="<?php echo $row['id']; ?>">

<?php echo $row['status']; ?>

</button>

</td>

<td>

<a href="EditJob.php?id=<?php echo $row['id']; ?>">
Edit
</a>

|

<a href="../Controller/JobController.php?delete=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

<link rel="stylesheet" href="../CSS/style.css">

<script src="../public/job-status.js"></script>
