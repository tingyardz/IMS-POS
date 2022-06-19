<?php
require_once("connection.php");
require_once("methods.php");
session_start();

if(!$_SESSION['ims-login']){

    header("Location:login.php");
}
elseif(isset($_GET['add'])){

    $methods->addItem();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="css/addItem.style.css">
    <link rel="shortcut icon" href="icon/inventory_icon.ico" type="image/x-icon">
</head>
<body>

<?php require_once("banner_menu.php"); ?>

<div class="wrapper">
    <div class="sub-wrapper">
    <h2>Add New Item</h2>
        <div class="back"><a href="index.php"><i class="fas fa-arrow-circle-left"></i> Back</a></div>

        <form action="" method="GET">

            <label for="">Code</label>
            <input type="text" name="code" required>
           
            <label for="">Brand</label>
            <input type="text" name="brand" required>
          
            <label for="">Type</label>
            <input type="text" name="type" required>
         
            <label for="">Current Stocks</label>
            <input type="number" name="currentStocks" required>
        
            <label for="">Price</label>
            <input type="number" step="0.01" name="price" required>
          
            <label for="">Min Stocks</label>
            <input type="number" name="minStocks" required>
    
            <button type="submit" name="add">Add Item</button>
        </form>

    </div>
</div>
    
</body>
</html>