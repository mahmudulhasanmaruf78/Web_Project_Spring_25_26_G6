<?php

$emailError="";

$passwordError="";

include "../Controller/LoginController.php";

echo "<h1>Login Page</h1><br>";

?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="../CSS/style.css">
                              
    </head>

<body>
    <div class="formbox">

<form method="post"
action="../Controller/LoginController.php">

<table>

<tr>

<td>
<label>Email :</label>
</td>

<td>

<input type="email"
name="email">

<?php
echo $emailError;
?>

</td>

</tr>



<tr>

<td>
<label>Password :</label>
</td>

<td>

<input type="password"
name="password">

<?php
echo $passwordError;
?>

</td>

</tr>



<tr>

<td>

<input type="submit"
name="submit"
value="Login">

</td>

</tr>

</table>

</form>
</div>
</body>

</html>