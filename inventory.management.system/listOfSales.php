<?php
require_once("connection.php");
require_once("methods.php");
session_start();

if(!$_SESSION['ims-login']){

    header("Location:login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="css/listOfSales.style.css">
    <link rel="shortcut icon" href="icon/inventory_icon.ico" type="image/x-icon">
</head>
<body>

<?php require_once("banner_menu.php"); ?>

<div class="container">
    <div class="wrapper">
        <h2>List of Sales</h2>
        <div class="back"><a href="index.php"><i class="fas fa-arrow-circle-left"></i> Back</a></div>

        <div class="sub-wrapper">
            <table>
                <tr>
                    <th>Date In</th>
                    <th>Time In</th>
                    <th>Sales</th>
                    <th>Date Out</th>
                    <th>Time Out</th>
                </tr>

            <?php

            $query = $methods->getDataFromSalesTable();

            if($query){

                $row = $query->fetch_assoc();

                do{
            ?>

                <tr>
                    <td><?php echo $row['Date In']; ?></td>
                    <td><?php echo $row['Time In']; ?></td>
                    <td>&#8369;<?php echo $row['Sales']; ?></td>
                    <td><?php echo $row['Date Out']; ?></td>
                    <td><?php echo $row['Time Out']; ?></td>
                </tr>

            <?php
                }while($row = $query->fetch_assoc());
            }
            ?>
            </table>

            <div class="reminder">
            <?php
                if(!$query){
                    echo "<h2>NO SALES YET!</h2>";
                }
            ?>
            </div>
            
        </div>
    </div>

</div>
    
</body>
</html>