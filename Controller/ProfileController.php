<?php

include "../config/db.php";
include "../Model/UserModel.php";



if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}



if($_SERVER["REQUEST_METHOD"]=="POST")
{

    $database = new db();

    $connection = $database->connection();

    $user = new UserModel();

    if(isset($_POST["update"]))
    {

        $userid=$_SESSION["user_id"];

        if($_FILES["file"]["name"]!="")
        {

            $targetdirectory=
            "../Public/uploads/";


            $path=$targetdirectory.basename(
                $_FILES["file"]["name"]
            );


            move_uploaded_file(
                $_FILES["file"]["tmp_name"],
                $path
            );

        }

        if(
        !empty($_POST["current_password"])
        &&
        !empty($_POST["new_password"])
        )
        {

            $currentpassword=
            $_POST["current_password"];

            $newpassword=
            $_POST["new_password"];



            $sql="SELECT * FROM users
            WHERE id='$userid'";

            $result=mysqli_query(
                $connection,
                $sql
            );

            $userdata=mysqli_fetch_assoc(
                $result
            );



            if(
            password_verify(
                $currentpassword,
                $userdata["password_hash"]
            )
            )
            {

                $hashpassword=
                password_hash(
                    $newpassword,
                    PASSWORD_DEFAULT
                );



                $updatepassword=
                $user->UpdatePassword(
                    $connection,
                    $userid,
                    $hashpassword
                );



                if($updatepassword)
                {
                    echo "Password Updated Successfully";
                }
                else
                {
                    echo "Password Not Updated";
                }

            }
            else
            {
                echo "Current Password Wrong";

                exit();
            }

        }

        if($_SESSION["role"]=="employer")
        {

            $company=
            $_POST["company_name"];

            $industry=
            $_POST["industry"];

            $description=
            $_POST["description"];

            $website=
            $_POST["website"];



            $update=
            $user->UpdateEmployerProfile(
                $connection,
                $userid,
                $company,
                $industry,
                $description,
                $website
            );



            if($update)
            {

                header(
                "Location:../View/EmployerDashboard.php"
                );

                exit();

            }

        }

        elseif($_SESSION["role"]=="seeker")
        {

            $headline=
            $_POST["headline"];

            $skills=
            $_POST["skills"];

            $experience=
            $_POST["experience"];



            $update=
            $user->UpdateSeekerProfile(
                $connection,
                $userid,
                $headline,
                $skills,
                $experience
            );



            if($update)
            {

                header(
                "Location:../View/SeekerDashboard.php"
                );

                exit();

            }

        }

    }


    else
    {
        if($_SESSION["role"]=="employer")
        {

            $userid = $_SESSION["user_id"];

            $company = $_POST["company_name"];

            $industry = $_POST["industry"];

            $description = $_POST["description"];

            $website = $_POST["website"];



            $result = $user->EmployerProfile(
                $connection,
                "employer_profiles",
                $userid,
                $company,
                $industry,
                $description,
                $website
            );



            if($result)
            {

                header(
                "Location:../View/EmployerDashboard.php"
                );

                exit();
            }
            else
            {
                echo "Profile Not Saved";
            }

        }

        elseif($_SESSION["role"]=="seeker")
        {

            $userid = $_SESSION["user_id"];

            $headline = $_POST["headline"];

            $skills = $_POST["skills"];

            $experience = $_POST["experience"];



            $result = $user->SeekerProfile(
                $connection,
                "seeker_profiles",
                $userid,
                $headline,
                $skills,
                $experience
            );



            if($result)
            {

                header(
                "Location:../View/SeekerDashboard.php"
                );

                exit();
            }
            else
            {
                echo "Profile Not Saved";
            }

        }

    }

}

?>
