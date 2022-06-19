<?php
require_once("connection.php");
require_once("methods.php");
session_start();

if(!$_SESSION['ims-login']){

    header("Location:login.php");
}
elseif(isset($_GET['logout'])){

    unset($_SESSION['ims-login']);
    header("Location:login.php");
}

//creating inventory database
$methods->createInventoryDatabase();

//creating inventory table
$methods->createInventoryTable();

//create sales table
$methods->createSalesTable();

//remove item
if(isset($_GET['remove'])){

    $id = $_GET['Id'];
    $methods->removeFromIndex($id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="css/index.style.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="shortcut icon" href="icon/inventory_icon.ico" type="image/x-icon">
</head>
<body>

<?php require_once("banner_menu.php"); ?>

<div class="container">
    <table>
        <tr>
            <th>Item Id</th>
            <th class="code">Code</th>
            <th class="brand">Brand</th>
            <th class="type">Type</th>
            <th>Current Stocks</th>
            <th>Price</th>
            <th>Action A</th>
            <th>Action B</th>
        </tr>

        <?php
            $query = $methods->getData();

            if($query){

                $row = $query->fetch_assoc();
                
                do{
        ?>

        <tr>
            <td><?php echo $row['Item Id']; ?></td>
            <td><?php echo $row['Code']; ?></td>
            <td><?php echo $row['Brand']; ?></td>
            <td><?php echo $row['Type']; ?></td>
            <td><?php echo $row['Current Stocks']; ?></td>
            <td>&#8369;<?php echo $row['Price']; ?></td>
            <td><a href="update.php?Id=<?php echo $row['Item Id']; ?>&from=index"><i class="fas fa-pencil-alt"></i></a></td>
            <td><a id="<?php echo $row['Item Id']; ?>" onclick="methods.remove(<?php echo $row['Item Id']; ?>)" href=""><i class="fas fa-trash-alt"></i></a></td>
        </tr>

        <?php
                }while($row = $query->fetch_assoc());
            }
        ?>
    </table>

    <div class="emptyAlert">
        <?php 

        if(!$query){

        echo "<h2>The Database Is Now Empty!</h2>";
        }
        ?>
    </div>
    
</div>

<!-- Script -->
<script src="js/JSMethods.js"></script>

</body>
</html>