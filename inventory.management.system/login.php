<?php

$correct_username = "admin";
$correct_password = "admin";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == $correct_username && $password == $correct_password){

        session_start();
        $_SESSION['ims-login'] = true;
        header("Location:index.php");
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
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="css/login.style.css">
    <link rel="shortcut icon" href="icon/inventory_icon.ico" type="image/x-icon">
</head>
<body>
    
<?php require_once("banner_menu.php"); ?>

<div class="wrapper">

    <h1>Inventory Management System</h1>

    <div class="sub-wrapper">
        <h2>Login</h2>

        <form action="" method="POST">
            <label for="">Username</label>
            <input type="text" name="username" autofocus required>

            <label for="">Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>

    </div>
</div>


</body>
</html>