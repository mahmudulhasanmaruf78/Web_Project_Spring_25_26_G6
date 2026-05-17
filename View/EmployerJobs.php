<?php
session_start();

require_once '../Model/JobModel.php';

// Create JobModel object
$model = new JobModel();

// Get all jobs of logged in employer
$jobs = $model->getJobs($_SESSION['user_id']);
?>

<!-- Add Job Link -->
<a href="AddJob.php">
    Add New Job
</a>

<br><br>

<!-- Job Table -->
<table border="1" cellpadding="10">

    <tr>
        <th>Job Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php
    while($row = $jobs->fetch_assoc())
    {
    ?>

    <tr>

        <!-- Job Title -->
        <td>
            <?php echo $row['title']; ?>
        </td>

        <!-- Category Name -->
        <td>
            <?php echo $row['category_name']; ?>
        </td>

        <!-- Status Button -->
        <td>

            <button
                class="status-btn"
                data-id="<?php echo $row['id']; ?>">

                <?php echo $row['status']; ?>

            </button>

        </td>

        <!-- Actions -->
        <td>

            <!-- Edit Button -->
            <a href="EditJob.php?id=<?php echo $row['id']; ?>">
                Edit
            </a>

            |

            <!-- Delete Button -->
            <a href="../Controller/JobController.php?delete=<?php echo $row['id']; ?>">
                Delete
            </a>

        </td>

    </tr>

    <?php
    }
    ?>

</table>

<!-- JavaScript File -->
<script src="../Controller/JS/job-status.js"></script>