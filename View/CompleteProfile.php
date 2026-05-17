<?php

session_start();

if(!isset($_SESSION["user_id"]))
{
    header("Location:Login.php");
}

include "../Controller/ProfileController.php";

?>

<!DOCTYPE html>

<html>

<head>

<link rel="stylesheet"
href="CSS/style.css">

</head>

<body>

<div class="formbox">

<h1>Complete Profile</h1>

<form method="post"
action="">

<table>

<?php

// EMPLOYER FORM
if($_SESSION["role"]=="employer")
{

?>

<tr>

<td>
Company Name :
</td>

<td>

<input type="text"
name="company_name">

</td>

</tr>



<tr>

<td>
Industry :
</td>

<td>

<select name="industry">

<option value="">
Select
</option>

<option value="Software">
Software
</option>

<option value="Business">
Business
</option>

<option value="Marketing">
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
name="description"></textarea>

</td>

</tr>



<tr>

<td>
Website :
</td>

<td>

<input type="text"
name="website">

</td>

</tr>

<?php

}



// SEEKER FORM
elseif($_SESSION["role"]=="seeker")
{

?>

<tr>

<td>
Headline :
</td>

<td>

<input type="text"
name="headline">

</td>

</tr>



<tr>

<td>
Skills :
</td>

<td>

<input type="text"
name="skills">

</td>

</tr>



<tr>

<td>
Years Experience :
</td>

<td>

<input type="number"
name="experience">

</td>

</tr>

<?php

}

?>



<tr>

<td colspan="2">

<input type="submit"
name="submit"
value="Save">

</td>

</tr>

</table>

</form>

</div>

</body>

</html>