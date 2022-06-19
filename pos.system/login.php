<?php
require_once("connection.php");
require_once("PHPMethods.php");

$correct_username = "admin";
$correct_password = "admin";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $dateIn = $_POST['date-in'];
    $timeIn = $_POST['time-in'];
    $sales = 0.00;

    if($username == $correct_username && $password == $correct_password){

        $methods->login($dateIn, $timeIn, $sales);
    }
    else{

        echo '<script>
                alert("Check your username or password!");
                window.location.href="login.php";
            </script>';
        
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale System</title>
    <link rel="stylesheet" href="css/login.style.css">
    <link rel="shortcut icon" href="icon/pos_icon.ico" type="image/x-icon">
</head>
<body>

<div class="wrapper">
    <h1>Point Of Sale System</h1>
    <div class="sub-wrapper">
        <h2>Login</h2>

        <form action="" method="POST">
            <label for="">Username</label>
            <input type="text" name="username" autofocus required>

            <label for="">Password</label>
            <input type="password" name="password" required>

            <input style="display: none" type="text" name="date-in" id="date-in">

            <input style="display: none" type="text" name="time-in" id="time-in">

            <button onclick="methods.displayDateTime()" type="submit" name="login">Login</button>
        </form>

    </div>
</div>

<!-- JavaScript -->
<script src="js/JSMethods.js"></script>

</body>
</html>