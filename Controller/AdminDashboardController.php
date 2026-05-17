<?php
session_start();

class AdminDashboardController
{
    public function handle(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            die("Unauthorized access. Please log in as an admin.");
        }

        // Load the view
        require __DIR__ . '/../View/admin.view.php';
    }
}

(new AdminDashboardController())->handle();
?>