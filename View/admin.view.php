<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access. Please log in as an admin.");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Job Portal</title>
    <link rel="stylesheet" href="../View/CSS/admin.css">

</head>
<body>
    <header class="top-navbar">
        <div class="nav-brand">JobPortal <span><?php echo $_SESSION["name"]; ?></span></div>
        <a href="../Controller/Logout.php" class="btn-logout">Logout</a>
    </header>

    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>

        <div class="summary-grid">
            <div class="summary-box">
                <p>Total Jobs</p>
                <h3 id="total_jobs">0</h3>
            </div>
            <div class="summary-box">
                <p>Total Applications</p>
                <h3 id="total_apps">0</h3>
            </div>
        </div>

        <h3>Applications per Category</h3>
        <table id="category_summary_table" style="margin-bottom: 30px;">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total Applications</th>
                </tr>
            </thead>
            <tbody id="category_summary_body">
            </tbody>
        </table>

        <div class="filter-bar">
            <label for="filter_category">Category:</label>
            <select id="filter_category">
                <option value="">All Categories</option>
                <option value="1">Engineering</option>
                <option value="2">Design</option>
                <option value="3">Marketing</option>
                <option value="4">Finance</option>
                <option value="5">Human Resources</option>
                <option value="6">Sales</option>
                <option value="7">Customer Support</option>
            </select>

            <label for="filter_status">Status:</label>
            <select id="filter_status">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="closed">Closed</option>
            </select>

            <button id="apply_filters" style="padding: 6px 12px;">Apply Filters</button>
        </div>

        <h3>Global Job Listings</h3>
        <table id="global_jobs_table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Employer</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="global_jobs_body">
            </tbody>
        </table>
    </div>

    <script src="../Controller/JS/admin.js"></script>
</body>

</html>