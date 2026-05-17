<?php
require_once '../Model/JobModel.php';
require_once '../Model/CategoryModel.php';

// Create model objects
$jobModel = new JobModel();
$categoryModel = new CategoryModel();

// Get job ID from URL
$id = $_GET['id'];

// Get single job data
$job = $jobModel->getJobById($id);
$row = $job->fetch_assoc();

// Get all categories
$categories = $categoryModel->getCategories();
?>

<h2>Update Job</h2>

<form action="../Controller/JobController.php" method="POST">

    <!-- Hidden Job ID -->
    <input type="hidden" name="id"
    value="<?php echo $row['id']; ?>">

    <!-- Job Title -->
    <label>Job Title:</label><br>

    <input type="text"
    name="title"
    value="<?php echo $row['title']; ?>">

    <br><br>

    <!-- Category -->
    <label>Select Category:</label><br>

    <select name="category_id">

        <?php
        while($cat = $categories->fetch_assoc())
        {
        ?>

        <option value="<?php echo $cat['id']; ?>">

            <?php echo $cat['name']; ?>

        </option>

        <?php
        }
        ?>

    </select>

    <br><br>

    <!-- Description -->
    <label>Description:</label><br>

    <textarea name="description"><?php echo $row['description']; ?></textarea>

    <br><br>

    <!-- Requirements -->
    <label>Requirements:</label><br>

    <textarea name="requirements"><?php echo $row['requirements']; ?></textarea>

    <br><br>

    <!-- Salary -->
    <label>Salary:</label><br>

    <input type="text"
    name="salary"
    value="<?php echo $row['salary_range']; ?>">

    <br><br>

    <!-- Location -->
    <label>Location:</label><br>

    <input type="text"
    name="location"
    value="<?php echo $row['location']; ?>">

    <br><br>

    <!-- Deadline -->
    <label>Deadline:</label><br>

    <input type="date"
    name="deadline"
    value="<?php echo $row['deadline']; ?>">

    <br><br>

    <!-- Update Button -->
    <button type="submit" name="update">
        Update Job
    </button>

</form>
