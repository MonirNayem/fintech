<?php

$host ="localhost";
$username = "root";
$password = "";
$database = "phpadminpanel";

//connection
$con = mysqli_connect("$host","$username","$password","$database");

//check connection
if(!$con)
{
    header("Location: ../errors/db.php");
    die();
}
// else
// {

// }

?>