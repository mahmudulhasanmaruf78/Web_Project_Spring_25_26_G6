<?php

class db
{
    function connection()
    {
        $connection = new mysqli("localhost", "root", "", "job_portal");
        if ($connection->connect_error) {
            die("Connection Failed: " . $connection->connect_error);
        }
        return $connection;
    }
}
?>
