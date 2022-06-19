<?php
require_once("connection.php");
require_once("methods.php");
session_start();

if(!$_SESSION['ims-login']){

    header("Location:login.php");
}

if(isset($_GET['Id'])){

    $query = $methods->getDataForUpdate();

    if($query){

        $row = $query->fetch_assoc();
    }
    else{

        header("Location:index.php");
    }
}
elseif(isset($_GET['updateItem'])){

    $methods->updateData();
}
else{

    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="css/update.style.css">
    <link rel="shortcut icon" href="icon/inventory_icon.ico" type="image/x-icon">
</head>
<body>

<?php require_once("banner_menu.php"); ?>

<div class="wrapper">
    <div class="sub-wrapper">
        <h2>Update Section</h2>
        <div class="back"><a href="index.php"><i class="fas fa-arrow-circle-left"></i> Back</a></div>

        <form action="" method="GET">
            <input class="itemId" type="number" name="itemId" value="<?php echo $row['Item Id']; ?>" readonly>

            <label for="">Code</label>
            <input type="text" name="code" value="<?php echo $row['Code']; ?>" disabled>
           
            <label for="">Brand</label>
            <input type="text" name="brand" value="<?php echo $row['Brand']; ?>">
          
            <label for="">Type</label>
            <input type="text" name="type" value="<?php echo $row['Type']; ?>">
         
            <label for="">Current Stocks</label>
            <input type="number" name="currentStocks" value="<?php echo $row['Current Stocks']; ?>" readonly>

            <label for="">Add New Stocks</label>
            <input type="number" name="addNewStocks" style="background-color: yellow" value="0" autofocus>
        
            <label for="">Price</label>
            <input type="number" name="price" step="0.01" value="<?php echo $row['Price']; ?>">
          
            <label for="">Min Stocks</label>
            <input type="number" name="minStocks" value="<?php echo $row['Min Stocks']; ?>">

            <input type="hidden" name="from" value="<?php echo $_GET['from']; ?>">
    
            <button type="submit" name="updateItem">Update Item</button>
        </form>

    </div>
</div>
    
</body>
</html>