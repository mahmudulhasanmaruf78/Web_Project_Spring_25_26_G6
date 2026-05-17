<?php
require_once '../Model/JobModel.php';
require_once '../Model/CategoryModel.php';

$jobModel = new JobModel();
$categoryModel = new CategoryModel();

$id = $_GET['id'];

$job = $jobModel->getJobById($id);
$row = $job->fetch_assoc();

$categories = $categoryModel->getCategories();
?>

<form action="../Controller/JobController.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<input type="text" name="title" value="<?php echo $row['title']; ?>"><br><br>

<select name="category_id">

<?php while($cat=$categories->fetch_assoc()) { ?>

<option value="<?php echo $cat['id']; ?>">
<?php echo $cat['name']; ?>
</option>

<?php } ?>

</select><br><br>

<textarea name="description"><?php echo $row['description']; ?></textarea><br><br>

<textarea name="requirements"><?php echo $row['requirements']; ?></textarea><br><br>

<input type="text" name="salary" value="<?php echo $row['salary_range']; ?>"><br><br>

<input type="text" name="location" value="<?php echo $row['location']; ?>"><br><br>

<input type="date" name="deadline" value="<?php echo $row['deadline']; ?>"><br><br>

<button type="submit" name="update">
Update Job
</button>

</form>
