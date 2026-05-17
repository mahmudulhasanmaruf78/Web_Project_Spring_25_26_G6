<?php
if (!isset($employerJobs)) {
    header("Location: ../Controller/DashboardController.php");
    exit;
}

if (!isset($warningMessage)) {
    $warningMessage = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Application Dashboard</title>
    <link rel="stylesheet" href="../View/CSS/dashboard.css">
</head>

<body>
    <header class="top-navbar">
        <div class="nav-brand">JobPortal <span><?php echo $_SESSION["name"]; ?>
            </span></div>
        <a href="../Controller/Logout.php" class="btn-logout">Logout</a>
    </header>

    <div class="dashboard-container">
        <h1>Application Dashboard</h1>

        <?php if (!empty($warningMessage) || empty($employerJobs)): ?>
            <div class="alert-warning">
                <strong>Database Warning:</strong>
                <?= htmlspecialchars($warningMessage) ?><br>
                <em>You need to insert test data into phpMyAdmin to see jobs here.</em>
            </div>
        <?php endif; ?>

        <label for="job_selector"><strong>Select Job:</strong></label>        <select id="job_selector">
            <option value="">Choose a Job</option>

            <?php if (!empty($employerJobs)): ?>
                <?php foreach ($employerJobs as $job): ?>
                    <option value="<?php echo htmlspecialchars($job['id']); ?>">
                        <?php echo htmlspecialchars($job['title']); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="" disabled>No Jobs Found in Database</option>
            <?php endif; ?>
        </select>

        <table id="applications_table">
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Headline</th>
                    <th>Date Applied</th>
                    <th>Cover Letter</th>
                    <th>Resume</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="application_body">
                <tr>
                    <td colspan="6">Select a job to view applications.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="chart-container">
        <canvas id="applicationFunnelChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../Controller/JS/dashboard.js"></script>
</body>

</html>