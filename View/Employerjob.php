<?php
session_start();

require_once '../Model/JobModel.php';

$model = new JobModel();

$jobs = $model->getJobs($_SESSION['user_id']);
?>

<a href="AddJob.php">Add Job</a>

<table border="1">

<tr>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row=$jobs->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['title']; ?></td>
<td><?php echo $row['category_name']; ?></td>

<td>
<button class="status-btn" data-id="<?php echo $row['id']; ?>">
<?php echo $row['status']; ?>
</button>
</td>

<td>

<a href="Editjob.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<a href="../Controller/JobController.php?delete=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

<script src="../Controller/JS/job-status.js"></script>
