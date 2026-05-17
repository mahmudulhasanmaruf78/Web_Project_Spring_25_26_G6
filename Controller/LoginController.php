<?php

include "../config/db.php";
include "../Model/UserModel.php";

session_start();

$email = "";
$password = "";

if($_SERVER["REQUEST_METHOD"]=="POST")
{

    $email = $_POST["email"];

    $password = $_POST["password"];



    if(!empty($email) && !empty($password))
    {

        $database = new db();

        $connection = $database->connection();

        $user = new UserModel();



        $result = $user->login(
            $connection,
            "users",
            $email
        );



        if($result)
        {

            if(password_verify(
                $password,
                $result["password_hash"]
            ))
            {

                $_SESSION["loggedIn"] = true;

                $_SESSION["user_id"] =
                $result["id"];

                $_SESSION["name"] =
                $result["name"];

                $_SESSION["role"] =
                $result["role"];

                $_SESSION["filepath"] =
                $result["file_path"];



                
                if($result["role"]=="employer")
                {

                    Header(
                    "Location:../View/EmployerDashboard.php"
                    );

                    exit();

                }


                elseif($result["role"]=="seeker")
                {

                    Header(
                    "Location:../View/SeekerDashboard.php"
                    );

                    exit();

                }


                elseif($result["role"]=="admin")
                {

                    Header(
                    "Location:../Controller/AdminDashboardController.php"
                    );

                    exit();

                }

            }
            else
            {
                echo "<h3>Wrong Password</h3>";
            }

        }
        else
        {
            echo "<h3>User Not Found</h3>";
        }

    }
    else
    {
        echo "<h3>Please Fill All Fields</h3>";
    }

}

?>
