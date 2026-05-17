
<?php

include "../config/db.php";
include "../Model/UserModel.php";

session_start();

$nameError="";
$emailError="";
$passwordError="";
$roleError="";
$fileError="";

if($_SERVER["REQUEST_METHOD"]=="POST")
{

    $name=$_POST["name"];

    $email=$_POST["email"];

    $password=$_POST["password"];



    $role="";

    if(isset($_POST["role"]))
    {
        $role=$_POST["role"];
    }



    $file=$_FILES["file"];

    $hasError=false;

    if(empty($name))
    {
        $nameError="Name Required";

        $hasError=true;
    }

    if(empty($email))
    {
        $emailError="Email Required";

        $hasError=true;
    }

    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $emailError="Invalid Email";

        $hasError=true;
    }

    if(empty($password))
    {
        $passwordError="Password Required";

        $hasError=true;
    }

    elseif(strlen($password)<8)
    {
        $passwordError="Minimum 8 Characters";

        $hasError=true;
    }



    if(empty($role))
    {
        $roleError="Select Role";

        $hasError=true;
    }

    if($file["name"]!="")
    {

        $fileextension=
        strtolower(
            pathinfo(
                $file["name"],
                PATHINFO_EXTENSION
            )
        );

        if($role=="seeker")
        {

            if($fileextension!="pdf")
            {
                $fileError=
                "Only PDF Allowed";

                $hasError=true;
            }

        }
        elseif($role=="employer")
        {

            if(
                $fileextension!="jpg" &&
                $fileextension!="jpeg" &&
                $fileextension!="png"
            )
            {

                $fileError=
                "Only JPG, JPEG, PNG Allowed";

                $hasError=true;

            }

        }

        if($file["size"] > 2000000)
        {

            $fileError=
            "File Must Be Less Than 2MB";

            $hasError=true;

        }

    }
    $database=new db();

    $connection=$database->connection();




    // EMAIL CHECK
    $checkQuery=
    "SELECT * FROM users
    WHERE email='$email'";


    $checkResult=
    mysqli_query(
        $connection,
        $checkQuery
    );



    if(mysqli_num_rows($checkResult)>0)
    {

        $emailError=
        "Email Already Exists";

        $hasError=true;

    }





    if($hasError==false)
    {




        // PASSWORD HASH
        $hashpassword=password_hash(
            $password,
            PASSWORD_DEFAULT
        );




        // FILE UPLOAD
        if($file["name"]!="")
        {

            $targetdirectory=
            "../Public/uploads/";


            $path=$targetdirectory.basename(
                $file["name"]
            );


            move_uploaded_file(
                $file["tmp_name"],
                $path
            );

        }
        else
        {
            $path="";
        }




        // USER MODEL
        $user=new UserModel();



        $result=$user->signup(
            $connection,
            "users",
            $name,
            $email,
            $hashpassword,
            $role,
            $path
        );



        if($result)
        {
            header(
            "Location:../View/Login.php"
            );

            exit();
        }
        else
        {
            echo "Database Error";
        }

    }

}

?>

