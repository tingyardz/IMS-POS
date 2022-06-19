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
    <link rel="stylesheet" href="css/stockAlert.style.css">
    <link rel="shortcut icon" href="icon/inventory_icon.ico" type="image/x-icon">
</head>
<body>
    
<?php require_once("banner_menu.php"); ?>

<div class="wrapper">
    <div class="sub-wrapper">
        <h3>The following items needs new stocks!</h3>
        <div class="back"><a href="index.php"><i class="fas fa-arrow-circle-left"></i> Back</a></div>
        
        <div class="container">
            <table>
                <tr>
                    <th>Item Id</th>
                    <th class="code">Code</th>
                    <th class="brand">Brand</th>
                    <th class="type">Type</th>
                    <th>Current Stocks</th>
                    <th>Recent Stocks</th>
                    <th>Price</th>
                    <th>Action</th>  
                </tr>

            <?php

                $query = $methods->getDataForStockAlert();
                $alert = false;

                if($query){

                    $row = $query->fetch_assoc();

                    do{

                        $currentStocks = $row['Current Stocks'];
                        $minStocks = $row['Min Stocks'];                       

                        if($currentStocks < $minStocks){
                            $alert = true;

            ?>        

                <tr>
                    <td><?php echo $row['Item Id']; ?></td>
                    <td><?php echo $row['Code']; ?></td>
                    <td><?php echo $row['Brand']; ?></td>
                    <td><?php echo $row['Type']; ?></td>
                    <td><em><?php echo $row['Current Stocks']; ?></em></td>
                    <td><?php echo $row['Recent Stocks']; ?></td>
                    <td>&#8369;<?php echo $row['Price']; ?></td>
                    <td><a href="update.php?Id=<?php echo $row['Item Id']; ?>&from=alert"><i class="fas fa-pencil-alt"></i></a></td>
                </tr>

            <?php
                        }
                    }while($row = $query->fetch_assoc());                   
                }
            ?>

            </table>

            <div class="label">
                <?php
                    if(!$alert){
                        echo "<h3>As of this moment no item need new supply</h3>";
                    }
                ?>  
            </div>
            
        </div>

    </div>
</div>

</body>
</html>