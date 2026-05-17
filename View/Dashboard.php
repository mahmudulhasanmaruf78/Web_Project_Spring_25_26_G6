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
        <link rel="stylesheet" href="../View/CSS/style.css">
                              
    </head>

<body>
    <div class="dashboard">

<h1>Dashboard</h1>

<br>

<?php

echo "Welcome ";

echo $_SESSION["name"];

?>

<br><br>

<?php

echo "Role : ";

echo $_SESSION["role"];

?>

<br><br>

<h3>Profile Incomplete</h3>

<a href="CompleteProfile.php">

Complete Your Profile

</a>

<br><br>

<a href="../Controller/Logout.php">

Logout

</a>

</div>

</body>

</html>
