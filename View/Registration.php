<?php

$name="";
$email="";

$nameError="";
$emailError="";
$passwordError="";
$roleError="";
$fileError="";

include "../Controller/RegistrationController.php";

?>

<!DOCTYPE html>

<html>

<head>

<title>Registration</title>

<link rel="stylesheet"
href="../View/CSS/style.css">

</head>

<body>

<div class="formbox">

<h1>Registration Page</h1>

<form method="post"
action=""
enctype="multipart/form-data">

<table>



<tr>

<td>
<label>Name :</label>
</td>

<td>

<input type="text"
name="name"
value="<?php echo $name; ?>">

<div class="error">
<?php echo $nameError; ?>
</div>

</td>

</tr>





<tr>

<td>
<label>Email :</label>
</td>

<td>

<input type="email"
name="email"
value="<?php echo $email; ?>">

<div class="error">
<?php echo $emailError; ?>
</div>

</td>

</tr>





<tr>

<td>
<label>Password :</label>
</td>

<td>

<input type="password"
name="password">

<div class="error">
<?php echo $passwordError; ?>
</div>

</td>

</tr>





<tr>

<td>
<label>Role :</label>
</td>

<td>

<input type="radio"
name="role"
value="employer">

Employer


<input type="radio"
name="role"
value="seeker">

Job Seeker


<div class="error">
<?php echo $roleError; ?>
</div>

</td>

</tr>





<tr>

<td>
File Upload :
</td>

<td>

<input type="file"
name="file">

<div class="error">
<?php echo $fileError; ?>
</div>

</td>

</tr>





<tr>

<td colspan="2">

<input type="submit"
name="submit"
value="Register">

<br><br>

<a href="Login.php">
Already Have Account? Login
</a>

</td>

</tr>



</table>

</form>

</div>

</body>

</html>
