<?php

Class Methods{

    public $connect;

    public function __construct($connect){

        $this->connect = $connect;
    }

    public function createInventoryDatabase(){

        $sql = "CREATE DATABASE IF NOT EXISTS `inventory_database`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
    }

    public function createInventoryTable(){

        $sql = "CREATE Table IF NOT EXISTS `inventory_database`.`inventory_table`
        (
            `Item Id` int (11) auto_increment primary key,
            `Code` varchar (100),
            `Brand` varchar (100),
            `Type` varchar (100),
            `Current Stocks` int (11),
            `Recent Stocks` int (11),
            `Min Stocks` int (11),
            `Price` float
        )
        ";
        $query = $this->connect->query($sql) or die ($this->connect->error);
    }

    public function getData(){

        $sql = "SELECT * FROM `inventory_database`.`inventory_table`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){

            return $query;
        }
        else{

            return false;
        }
    }

    public function addItem(){

        $code = $_GET['code'];
        $brand = $_GET['brand'];
        $type = $_GET['type'];
        $currentStocks = $_GET['currentStocks'];
        $recentStocks = $currentStocks;
        $minStocks = $_GET['minStocks'];
        $price = $_GET['price'];

        $sql = "SELECT * FROM `inventory_database`.`inventory_table` WHERE `Code` = '$code'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        if($total > 0){
            echo '<script>
                    alert("The code you had entered was already exist!");
                    window.location.href="addItem.php";
                </script>';
            exit();
        }

        $sql = "INSERT INTO `inventory_database`.`inventory_table` (`Code`,`Brand`,`Type`,`Current Stocks`,`Recent Stocks`,`Min Stocks`,`Price`) 
                VALUES ('$code','$brand','$type','$currentStocks','$recentStocks','$minStocks','$price')";
        $query = $this->connect->query($sql) or die ($this->connect->error);

            echo '<script>
                    alert("The new item has been successfully added to the database.");
                    window.location.href="addItem.php";
                </script>';
    }

    public function removeFromIndex($id){

        $sql = "DELETE FROM `inventory_database`.`inventory_table` WHERE `Item Id` = '$id'";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        echo '<script>
            alert("The item has been successfully removed from the database.");
            window.location.href="index.php";
            </script>';
    }

    public function searchFromCode($code){

        $sql = "SELECT * FROM `inventory_database`.`inventory_table` WHERE `Code` = '$code'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total == 1){

            return $query;
        }
        else{

            return false;
        }
    }

    public function searchFromBrandType($type_brand){

        $sql = "SELECT * FROM `inventory_database`.`inventory_table` WHERE `Brand` LIKE '%$type_brand%' || `Type` LIKE '%$type_brand%'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){

            return $query;
        }
        else{

            return false;
        }
    }

    public function removeItemFromSearch($id){

        $sql = "DELETE FROM `inventory_database`.`inventory_table` WHERE `Item Id` = '$id'";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        echo '<script>
                alert("The item has been successfully removed from the database.");
                window.location.href="search.php";
            </script>';
    }

    public function getDataForStockAlert(){

        $sql = "SELECT * FROM `inventory_database`.`inventory_table`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){

            return $query;
        }
        else{

            return false;
        }
    }

    public function createSalesTable(){

        $sql = "CREATE TABLE IF NOT EXISTS `inventory_database`.`sales_table` 
                (
                    `Id` int (11) auto_increment primary key,
                    `Date In` varchar (50),
                    `Time In` varchar (50),
                    `Sales` float,
                    `Date Out` varchar (50),
                    `Time Out` varchar (50)
                )";
        $query = $this->connect->query($sql) or die ($this->connect->error);
    }

    public function getDataFromSalesTable(){

        $sql = "SELECT * FROM `inventory_database`.`sales_table` ORDER BY `Id` DESC";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){

            return $query;
        }
        else{

            return false;
        }
    }

    public function getDataForUpdate(){

        $id = $_GET['Id'];
        $sql = "SELECT * FROM `inventory_database`.`inventory_table` WHERE `Item Id` = '$id'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total == 1){

            return $query;
        }
        else{

            return false;
        }
    }

    public function updateData(){

        $itemId = $_GET['itemId'];
        $code = $_GET['code'];
        $brand = $_GET['brand'];
        $type = $_GET['type'];
        $currentStocks = $_GET['currentStocks'] + $_GET['addNewStocks'];
        $recentStocks = $currentStocks;
        $minStocks = $_GET['minStocks'];
        $price = $_GET['price'];
        $from = $_GET['from'];

        $sql = "UPDATE `inventory_database`.`inventory_table` 
                SET `Code` = '$code',`Brand` = '$brand',`Type` = '$type',`Current Stocks` = '$currentStocks',`Recent Stocks` = '$recentStocks',`Min Stocks` = '$minStocks',`Price` = '$price' WHERE `Item Id` = '$itemId'";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        if($from == "index"){

            echo '<script>
                    alert("The item has been successfully updated...");
                    window.location.href="index.php";
                </script>';
        }elseif($from == "search"){

            echo '<script>
                    alert("The item has been successfully updated...");
                    window.location.href="search.php";
                </script>';
        }elseif($from == "alert"){

            echo '<script>
                    alert("The item has been successfully updated...");
                    window.location.href="stockAlert.php";
                </script>';
        }


            
    }

}

    $methods = new Methods($connect);

?>