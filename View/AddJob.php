<?php
require_once '../Model/CategoryModel.php';

$model = new CategoryModel();

$categories = $model->getCategories();
?>

<h2>Add Job</h2>

<form action="../Controller/JobController.php" method="POST">

<input type="text" name="title" placeholder="Job Title"><br><br>

<select name="category_id">

<?php while($row=$categories->fetch_assoc()) { ?>

<option value="<?php echo $row['id']; ?>">
<?php echo $row['name']; ?>
</option>

<?php } ?>

</select><br><br>

<textarea name="description" placeholder="Description"></textarea><br><br>

<textarea name="requirements" placeholder="Requirements"></textarea><br><br>

<input type="text" name="salary" placeholder="Salary"><br><br>

<input type="text" name="location" placeholder="Location"><br><br>

<input type="radio" name="job_type" value="Full-time"> Full-time

<input type="radio" name="job_type" value="Part-time"> Part-time

<input type="radio" name="job_type" value="Remote"> Remote

<br><br>

<input type="date" name="deadline"><br><br>

<button type="submit" name="create">
Create Job
</button>

</form>
