<?php
require_once("connection.php");
require_once("methods.php");
session_start();

$query = false;

if(!$_SESSION['ims-login']){

    header("Location:login.php");
}

//search item by its code
elseif(isset($_GET['search1'])){

    $code = $_GET['code'];
    $query = $methods->searchFromCode($code);
    
    if(!$query){

        echo '<script>
                alert("There is no such item found!");
                window.location.href="search.php";
             </script>';
    }
}

//search item by its type or brand
elseif(isset($_GET['search2'])){

    $type_brand = $_GET['type_brand'];
    $query = $methods->searchFromBrandType($type_brand);
    
    if(!$query){

        echo '<script>
                alert("There is no such item found!");
                window.location.href="search.php";
            </script>';
    }
}

//removing the item
elseif(isset($_GET['remove'])){

    $id = $_GET['Id'];
    $methods->removeItemFromSearch($id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="css/search.style.css">
    <link rel="shortcut icon" href="icon/inventory_icon.ico" type="image/x-icon">
</head>
<body>
    
<?php require_once("banner_menu.php"); ?>

<div class="wrapper">
    <div class="sub-wrapper">
    <h2>Searching Section</h2>
    <div class="back"><a href="index.php"><i class="fas fa-arrow-circle-left"></i> Back</a></div>

    <form action="">
        <input type="text" name="code" placeholder="Enter the code" required>
        <button type="submit" name="search1">Search</button>
    </form>

    <form action="">
        <input type="text" name="type_brand" placeholder="Enter the brand/type" required>
        <button type="submit" name="search2">Search</button>
    </form>

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
                <td><a href="update.php?Id=<?php echo $row['Item Id']; ?>&from=search"><i class="fas fa-pencil-alt"></i></a></td>
                <td><a id="<?php echo $row['Item Id']; ?>" onclick="methods.removeItemFromSearch(<?php echo $row['Item Id']; ?>)" href=""><i class="fas fa-trash-alt"></i></a></td>
            </tr>

        <?php
                }while($row = $query->fetch_assoc());
            }
        ?>
        </table>

        <div class="searching">
            <?php
                if(!$query){
                    echo "<h2>Search for an item.</h2>";
                }
            ?>
        </div>
        

    </div>

    </div>
</div>

<!-- Script -->
<script src="js/JSMethods.js"></script>

</body>
</html>