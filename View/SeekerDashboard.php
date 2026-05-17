<?php

session_start();

if(!isset($_SESSION["user_id"]))
{
    header("Location:Login.php");
}

include "../config/db.php";
include "../Model/UserModel.php";

$database=new db();

$connection=$database->connection();

$user=new UserModel();

$profile=
$user->CheckSeekerProfile(
    $connection,
    $_SESSION["user_id"]
);

?>

<!DOCTYPE html>

<html>

<head>

<link rel="stylesheet"
href="../View/CSS/style.css">

</head>

<body>

<div class="formbox">

<h1>Seeker Dashboard</h1>

<h3>

Welcome

<?php
echo $_SESSION["name"];
?>

</h3>

<br>

<?php

if($profile==0)
{

    echo "<h3>Profile Incomplete</h3>";

    echo '

    <a href="CompleteProfile.php">

    Complete Profile

    </a>

    ';

}

?>

<br><br>

<a href="EditProfile.php">

Edit Profile

</a>

<br><br>

<a href="../Controller/Logout.php">

Logout

</a>

</div>

</body>

</html>
