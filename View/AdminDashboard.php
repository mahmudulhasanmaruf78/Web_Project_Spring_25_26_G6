<?php

session_start();

if(!isset($_SESSION["user_id"]))
{
    header("Location:Login.php");
}

?>

<!DOCTYPE html>

<html>

<head>

<link rel="stylesheet"
href="CSS/style.css">

</head>

<body>

<div class="formbox">

<h1>Admin Dashboard</h1>

<h3>

Welcome

<?php
echo $_SESSION["name"];
?>

</h3>

<br>

<a href="../Controller/AdminDashboardController.php">

Open Admin Panel (Job Management)

</a>

<br><br>

<a href="../Controller/Logout.php">

Logout

</a>

</div>

</body>

</html>