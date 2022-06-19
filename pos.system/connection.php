<?php
$serverName = "localhost";
$userName = "root";
$password = "tingards09";

$connect = mysqli_connect($serverName,  $userName,  $password);

if(mysqli_connect_errno()){

    echo "Connection Failed!";
}

?>