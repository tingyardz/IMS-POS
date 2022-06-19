<?php
require_once("connection.php");
session_start();

if(isset($_GET['truncate'])){

$dateIn = $_SESSION['date-in'];
$timeIn = $_SESSION['time-in'];
$totalAmount = $_SESSION['total-amount'] + $_SESSION['current-sale'];

         //Reducing stocks from inventory
         $sql_pos = "SELECT * FROM `pos_database`.`pos_table`";
         $query_pos = $connect->query($sql_pos) or die ($connect->error);
         $row_pos = $query_pos->fetch_assoc();

         do{

            $id = $row_pos['Original Item Id'];
            $quantity = $row_pos['Quantity'];

            $sql_inventory = "SELECT * FROM `inventory_database`.`inventory_table` WHERE `Item Id` = '$id'";
            $query_inventory = $connect->query($sql_inventory) or die ($connect->error);
            $row_inventory = $query_inventory->fetch_assoc();

            $newCurrentStocks = $row_inventory['Current Stocks'] - $quantity;

            $sql_inventory = "UPDATE `inventory_database`.`inventory_table` SET `Current Stocks` = '$newCurrentStocks' WHERE `Item Id` = '$id'";
            $query_inventory = $connect->query($sql_inventory) or die ($connect->error);
            
         }while($row_pos = $query_pos->fetch_assoc());

         //Adding the new sale 
           $sql_storeSale = "UPDATE `inventory_database`.`sales_table` SET `Sales`='$totalAmount' WHERE `Date In` = '$dateIn' AND `Time In` = '$timeIn'";
           $query_storeSale = $connect->query($sql_storeSale) or die ($connect->error);

         //Removing all data from pos table
           $sql_truncate = "TRUNCATE `pos_database`.`pos_table`";
           $query_truncate = $connect->query($sql_truncate) or die ($connect->error);

           header("Location:index.php");

}else{

    header("Location:index.php");
    exit();
}
?>