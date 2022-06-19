<?php

class Methods{

    public $connect;

    public function __construct($connect){

        $this->connect = $connect;
    }

    public function createPOSDB(){

        $sql = "CREATE DATABASE IF NOT EXISTS `pos_database`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
    }

    public function poslogout($dateIn,$timeIn){

        $dateOut = $_GET['dateOut'];
        $timeOut = $_GET['timeOut'];

        $sql = "UPDATE `inventory_database`.`sales_table` SET `Date Out`='$dateOut', `Time Out` = '$timeOut' WHERE `Date In` = '$dateIn' AND `Time In` = '$timeIn'";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        unset($_SESSION['pos-login']);
        header("Location:login.php");
    }

    public function createposTable(){

        $sql = "CREATE Table IF NOT EXISTS `pos_database`.`pos_table`
                (
                    `Item Id` int (11) auto_increment primary key,
                    `Code` varchar (100),
                    `Description` varchar (100),
                    `Quantity` int (11),
                    `Price` float (11),
                    `Amount` float (11),
                    `Original Item Id` int (11)
                )
                ";
        $query = $this->connect->query($sql) or die ($this->connect->error);

    }

    public function addItemFromCode(){

        $code = $_GET['code'];
        $qty = $_GET['quantity'];

        $sql = "SELECT * FROM `inventory_database`.`inventory_table` WHERE `Code` = '$code'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        if($total == 1){

            $code = $row['Code'];
            $description = $row['Brand']." ".$row['Type'];
            $quantity = $qty;
            $price = $row['Price'];
            $amount = $row['Price'] * $quantity;
            $originalItemId = $row['Item Id'];

            $sql = "INSERT INTO `pos_database`.`pos_table`(`Code`, `Description`, `Quantity`, `Price`, `Amount`, `Original Item Id`) 
                    VALUES ('$code','$description','$quantity','$price','$amount', '$originalItemId')";
            $query = $this->connect->query($sql) or die ($this->connect->error);
        
            header("Location:index.php");
        }
        else{

            echo '<script>
                alert("There is no such item found!");
                window.location.href="index.php";
            </script>';
        }
    }

    public function addItemFromSearching(){

        $id = $_GET['item-id'];
        $qty = $_GET['quantity'];

        $sql = "SELECT * FROM `inventory_database`.`inventory_table` WHERE `Item Id` = '$id'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        if($total == 1){

            $code = $row['Code'];
            $description = $row['Brand']." ".$row['Type'];
            $quantity = $qty;
            $price = $row['Price'];
            $amount = $row['Price'] * $quantity;
            $originalItemId = $row['Item Id'];

            $sql = "INSERT INTO `pos_database`.`pos_table`(`Code`, `Description`, `Quantity`, `Price`, `Amount`, `Original Item Id`) 
                    VALUES ('$code','$description','$quantity','$price','$amount', '$originalItemId')";
            $query = $this->connect->query($sql) or die ($this->connect->error);

            header("Location:index.php");
        }
    }

    public function removeItem(){

        $id = $_GET['Id'];
    
        $sql = "DELETE FROM `pos_database`.`pos_table` WHERE `Item Id` = '$id'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
    
        echo '<script>
                alert("The item has been successfully removed.");
                window.location.href="index.php";
            </script>';
    }

    public function getData(){

        $sql = "SELECT * FROM `pos_database`.`pos_table` ORDER BY `Item Id` DESC";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){

            return $query;
        }
        else{

            return false;
        }
    }

    public function getDataFromSearch(){

        $brand_type = $_GET['brand-type'];
          
        $sql = "SELECT * FROM `inventory_database`.`inventory_table` WHERE `Brand` LIKE '$brand_type%' || `Type` LIKE '$brand_type%'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){

            return $query;
        }
        else{

            return false;
        }
    }

    public function getDataFromSalesTable($dateIn, $timeIn){

        $sql = "SELECT * FROM `inventory_database`.`sales_table` WHERE `Date In` = '$dateIn' AND `Time In` = '$timeIn'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){

            return $query;
        }
        else{

            return false;
        }

    }

    public function login($dateIn, $timeIn, $sales){

        session_start();
        $_SESSION['pos-login'] = true;
        $_SESSION['date-in'] = $dateIn;
        $_SESSION['time-in'] = $timeIn;

        $sql = "INSERT INTO `inventory_database`.`sales_table`(`Date In`, `Time In`, `Sales`) 
                VALUES ('$dateIn','$timeIn','$sales')";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        header("Location:index.php");
    }


}

$methods = new Methods($connect);

?>