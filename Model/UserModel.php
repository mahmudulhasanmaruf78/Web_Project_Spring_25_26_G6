
<?php

class UserModel
{

    function signup(
        $connection,
        $table,
        $name,
        $email,
        $password,
        $role,
        $path
    )
    {

        $sql="INSERT INTO $table

        (name,email,password_hash,
        role,file_path)

        VALUES

        ('$name','$email','$password',
        '$role','$path')";

        return mysqli_query(
            $connection,
            $sql
        );

    }




    function login(
        $connection,
        $table,
        $email
    )
    {

        $sql="SELECT * FROM $table
        WHERE email='$email'";

        $result=mysqli_query(
            $connection,
            $sql
        );

        return mysqli_fetch_assoc(
            $result
        );

    }




    function EmployerProfile(
        $connection,
        $table,
        $userid,
        $company,
        $industry,
        $description,
        $website
    )
    {

        $sql="INSERT INTO $table

        (user_id,company_name,
        industry,description,
        website)

        VALUES

        ('$userid','$company',
        '$industry','$description',
        '$website')";

        return mysqli_query(
            $connection,
            $sql
        );

    }




    function SeekerProfile(
        $connection,
        $table,
        $userid,
        $headline,
        $skills,
        $experience
    )
    {

        $sql="INSERT INTO $table

        (user_id,headline,
        skills,years_experience)

        VALUES

        ('$userid','$headline',
        '$skills','$experience')";

        return mysqli_query(
            $connection,
            $sql
        );

    }




    function CheckEmployerProfile(
        $connection,
        $userid
    )
    {

        $sql="SELECT * FROM
        employer_profiles

        WHERE user_id='$userid'";

        $result=mysqli_query(
            $connection,
            $sql
        );

        return mysqli_num_rows(
            $result
        );

    }




    function CheckSeekerProfile(
        $connection,
        $userid
    )
    {

        $sql="SELECT * FROM
        seeker_profiles

        WHERE user_id='$userid'";

        $result=mysqli_query(
            $connection,
            $sql
        );

        return mysqli_num_rows(
            $result
        );

    }




    function GetEmployerProfile(
        $connection,
        $userid
    )
    {

        $sql="SELECT * FROM
        employer_profiles

        WHERE user_id='$userid'";

        $result=mysqli_query(
            $connection,
            $sql
        );

        return mysqli_fetch_assoc(
            $result
        );

    }




    function GetSeekerProfile(
        $connection,
        $userid
    )
    {

        $sql="SELECT * FROM
        seeker_profiles

        WHERE user_id='$userid'";

        $result=mysqli_query(
            $connection,
            $sql
        );

        return mysqli_fetch_assoc(
            $result
        );

    }




    function UpdateEmployerProfile(
        $connection,
        $userid,
        $company,
        $industry,
        $description,
        $website
    )
    {

        $sql="UPDATE employer_profiles

        SET

        company_name='$company',
        industry='$industry',
        description='$description',
        website='$website'

        WHERE user_id='$userid'";

        return mysqli_query(
            $connection,
            $sql
        );

    }




    function UpdateSeekerProfile(
        $connection,
        $userid,
        $headline,
        $skills,
        $experience
    )
    {

        $sql="UPDATE seeker_profiles

        SET

        headline='$headline',
        skills='$skills',
        years_experience='$experience'

        WHERE user_id='$userid'";

        return mysqli_query(
            $connection,
            $sql
        );

    }




    function UpdatePassword(
        $connection,
        $userid,
        $newpassword
    )
    {

        $sql="UPDATE users

        SET

        password_hash='$newpassword'

        WHERE id='$userid'";

        return mysqli_query(
            $connection,
            $sql
        );

    }

}

?>

