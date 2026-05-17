<?php
require_once '../Model/CategoryModel.php';

// Create category model object
$model = new CategoryModel();

// Get all categories
$categories = $model->getCategories();
?>

<h2>Add New Job</h2>

<form action="../Controller/JobController.php" method="POST">

    <!-- Job Title -->
    <label>Job Title:</label><br>
    <input type="text" name="title"><br><br>

    <!-- Category -->
    <label>Select Category:</label><br>

    <select name="category_id">

        <?php
        while($row = $categories->fetch_assoc())
        {
        ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['name']; ?>
            </option>

        <?php
        }
        ?>

    </select>

    <br><br>

    <!-- Description -->
    <label>Description:</label><br>

    <textarea name="description"></textarea>

    <br><br>

    <!-- Requirements -->
    <label>Requirements:</label><br>

    <textarea name="requirements"></textarea>

    <br><br>

    <!-- Salary -->
    <label>Salary:</label><br>

    <input type="text" name="salary">

    <br><br>

    <!-- Location -->
    <label>Location:</label><br>

    <input type="text" name="location">

    <br><br>

    <!-- Job Type -->
    <label>Job Type:</label><br>

    <input type="radio" name="job_type" value="Full-time">
    Full-time

    <input type="radio" name="job_type" value="Part-time">
    Part-time

    <input type="radio" name="job_type" value="Remote">
    Remote

    <br><br>

    <!-- Deadline -->
    <label>Application Deadline:</label><br>

    <input type="date" name="deadline">

    <br><br>

    <!-- Submit Button -->
    <button type="submit" name="create">
        Create Job
    </button>

</form>
