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


if($_SESSION["role"]=="employer")
{

    $data=$user->GetEmployerProfile(
        $connection,
        $_SESSION["user_id"]
    );

}



// SEEKER DATA
elseif($_SESSION["role"]=="seeker")
{

    $data=$user->GetSeekerProfile(
        $connection,
        $_SESSION["user_id"]
    );

}

?>

<!DOCTYPE html>

<html>

<head>

<link rel="stylesheet"
href="../CSS/style.css">

</head>

<body>

<div class="formbox">

<h1>Edit Profile</h1>

<br>

<form method="post"
action="../Controller/ProfileController.php"
enctype="multipart/form-data">

<table>

<?php

// EMPLOYER EDIT
if($_SESSION["role"]=="employer")
{

?>

<tr>

<td>
Company Name :
</td>

<td>

<input type="text"
name="company_name"

value="<?php
echo $data["company_name"];
?>">

</td>

</tr>



<tr>

<td>
Industry :
</td>

<td>

<select name="industry">

<option value="Software"

<?php

if($data["industry"]=="Software")
{
    echo "selected";
}

?>

>
Software
</option>



<option value="Business"

<?php

if($data["industry"]=="Business")
{
    echo "selected";
}

?>

>
Business
</option>



<option value="Marketing"

<?php

if($data["industry"]=="Marketing")
{
    echo "selected";
}

?>

>
Marketing
</option>

</select>

</td>

</tr>



<tr>

<td>
Description :
</td>

<td>

<textarea
name="description"><?php
echo $data["description"];
?></textarea>

</td>

</tr>



<tr>

<td>
Website :
</td>

<td>

<input type="text"
name="website"

value="<?php
echo $data["website"];
?>">

</td>

</tr>

<?php

}



// SEEKER EDIT
elseif($_SESSION["role"]=="seeker")
{

?>

<tr>

<td>
Headline :
</td>

<td>

<input type="text"
name="headline"

value="<?php
echo $data["headline"];
?>">

</td>

</tr>



<tr>

<td>
Skills :
</td>

<td>

<input type="text"
name="skills"

value="<?php
echo $data["skills"];
?>">

</td>

</tr>



<tr>

<td>
Years Experience :
</td>

<td>

<input type="number"
name="experience"

value="<?php
echo $data["years_experience"];
?>">

</td>

</tr>

<?php

}

?>



<tr>

<td>
Upload New File :
</td>

<td>

<input type="file"
name="file">

</td>

</tr>



<tr>

<td>
Current Password :
</td>

<td>

<input type="password"
name="current_password">

</td>

</tr>



<tr>

<td>
New Password :
</td>

<td>

<input type="password"
name="new_password">

</td>

</tr>



<tr>

<td>

<input type="submit"
name="update"
value="Update Profile">

</td>

</tr>

</table>

</form>

</div>

</body>

</html>
