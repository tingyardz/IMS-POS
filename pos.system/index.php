<?php
require_once("connection.php");
require_once("PHPMethods.php");

session_start();
$dateIn = $_SESSION['date-in'];
$timeIn = $_SESSION['time-in'];
$totalAmount = 0.00;

//Login and Logout
if(!$_SESSION['pos-login']){

    header("Location:login.php");
}
elseif(isset($_GET['logout'])){

    $methods->poslogout($dateIn,$timeIn);
}

//Create POS Database
    $methods->createPOSDB();

//Creating POS Table
    $methods->createposTable();

//Add New Item By Its Code
    if(isset($_GET['add-1'])){

        $methods->addItemFromCode();
    }
//add item by its type or brand
    elseif(isset($_GET['add-2'])){

        $methods->addItemFromSearching();
    }
//removing data
    if(isset($_GET['remove'])){

        $methods->removeItem();
    }

//Get the data from sales table
    $sales_query = $methods->getDataFromSalesTable($dateIn, $timeIn);

    if($sales_query){

        $sales_row = $sales_query->fetch_assoc();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point Of Sale System</title>
    <link rel="stylesheet" href="css/index.style.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/jquery.min.js"></script>
    <link rel="shortcut icon" href="icon/pos_icon.ico" type="image/x-icon">
</head>

<body>

<div class="header">
    <h3>My_POS System</h3>
</div>

<nav>
    <ul>
        <li class="date-in">Date In: <?php echo $sales_row['Date In']; ?></li>
        <li class="time-in">Time In: <?php echo $sales_row['Time In']; ?></li>
        <li class="income"><a onclick="totalSales()" style="cursor: pointer">Sales</a></li>
        <li class="logout"><a onclick="methods.logout(this)" href="">Logout</a></li>
    </ul>
</nav>

<div class="form-container">
    <form class="form-1" action="">
        <label for="">Qty: </label>
        <input class="quantity" type="number" name="quantity" value="1" required>
        <input  id="code" type="text" name="code" placeholder="Enter the code" autofocus required>
        <button type="submit" name="add-1">Add</button>
    </form>
    
    <form class="form-2" action="">
        <input  id="brand-type" type="text" name="brand-type" placeholder="Enter the brand/type" required>
        <button type="submit" name="search">Search</button>
    </form>

</div>

<div class="container">
    <div class="wrapper-1">
        <table>
            <tr>
                <th class="code">Code</th>
                <th class="description">Description</th>
                <th class="quantity">Quantity</th>
                <th>Price</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>

        <?php 

        $query = $methods->getData();

        if($query){

            $row = $query->fetch_assoc();

            do{
                $totalAmount = $totalAmount + $row['Amount'];
        ?>
            <tr>
                <td><?php echo $row['Code']; ?></td>
                <td><?php echo $row['Description']; ?></td>
                <td><?php echo $row['Quantity']; ?></td>
                <td>&#8369;<?php echo $row['Price']; ?></td>
                <td>&#8369;<?php echo $row['Amount']; ?></td>
                <td><a id="<?php echo $row['Item Id']; ?>" onclick="methods.remove(<?php echo $row['Item Id']; ?>)" href=""><i class="fas fa-trash-alt"></i></a></td>
            </tr>
        <?php
            }while($row = $query->fetch_assoc());
        }
        ?>
        
        </table>

    </div>

    <div class="wrapper-2">
        <div class="total">
            <h1>Total</h1>
            <div id="totalAmount"><h4 id="totalAmount-content"><?php if($totalAmount != 0){ echo "&#8369;".$totalAmount;}else{echo "&#8369;0.00";} ?></h4></div>
        </div>

        <div class="cash">
            <h1>Cash</h1>
            <input id="cash" onkeyup="methods.cashToChange(this)" type="number" name="cash" placeholder="0.00">
        </div>

        <div class="change-wrapper">
            <h1>Change</h1>
            <div class="change">&#8369;0</div>
            
        </div>

        <div class="btn-wrapper">
            <button onclick="nextTransaction()">(F2) Next Transaction</button>
            <a id="print-location" onclick="printReceipt()"><button>(F4) Print Receipt</button></a>
        </div>
    </div>
</div>

<!--Search New Page-->
<?php
    if(isset($_GET['search'])){
?>

<div class="search-new-page">

    <div class="wrapper">

        <div class="close">
            <a href="index.php"><i class="fas fa-arrow-circle-left"></i> Back</a>
        </div>

        <div class="sub-wrapper">
            <table>
                <tr>
                    <th>Item Id</th>
                    <th>Code</th>
                    <th>Brand</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>

<!-- Searching the item -->
    <?php               
            
            $query = $methods->getDataFromSearch();
            
            if($query){

                $row = $query->fetch_assoc();

                do{
    ?>

                <tr>
                    <td><?php echo $row['Item Id']; ?></td>
                    <td><?php echo $row['Code']; ?></td>
                    <td><?php echo $row['Brand']; ?></td>
                    <td><?php echo $row['Type']; ?></td>
                    <td>&#8369;<?php echo $row['Price']; ?></td>
                    <form action="">
                    <input type="number" name="item-id" value="<?php echo $row['Item Id']; ?>" style="display:none">
                    <td><input id="quant" type="number" name="quantity" value="1" required></td>
                    <td><button type="submit" name="add-2"><strong>Add</strong</button></td>
                    </form>
                </tr>

    <?php
                }while($row = $query->fetch_assoc());
            }
            else{

                echo '<script>
                         alert("There is no such item found!");
                         window.location.href="index.php";
                     </script>';
            }
    ?>
            </table>
        </div>
    </div>

</div>

<script>
    $('.search-new-page').css("display", "flex");
</script>

<?php
    }
?>

<!-- JavaScript -->
<script src="js/JSMethods.js"></script>

<script>  
    $(document).ready(function(){
        $('input').keydown(function(event){
            var key = event.which || event.keyCode;
                if(key == 113){
                    nextTransaction();
                }
                else if(key == 115){
                    printReceipt();
                }
                else if(key == 39){
                    var input = document.activeElement;
                    var inputs = $('input');
                    var inputNum;
                    for(var i = 0; i < inputs.length; i++){
                        if(inputs[i] == input){
                            inputNum = i + 1;
                        }
                    }
                    if(inputNum < inputs.length){
                        inputs[inputNum].focus();
                    }else{
                        inputs[0].focus();
                    }
                }
                else if(key == 37){
                    var input = document.activeElement;
                    var inputs = $('input');
                    var inputNum;
                    for(var i = 0; i < inputs.length; i++){
                        if(inputs[i] == input){
                            inputNum = i - 1;
                        }
                    }
                    if(inputNum >= 0){
                        inputs[inputNum].focus();
                    }
                    else{
                        inputs[inputs.length - 1].focus();
                    }
                }
        });
    });


    function totalSales(){

        alert("Total sales today: ₱<?php echo $sales_row['Sales']; ?>");
        window.location.href="index.php";
    }

    function nextTransaction(){

        var decision = confirm("Are you sure to proceed to the next transaction?\nThen click ok.");
        var checkTheTable = "<?php if($query){echo true;}else{echo false;} ?>";

        if(decision == true && checkTheTable == true){

            window.location.href="truncate_posTable.php?truncate=";
        }
        else{

            window.location.href="index.php";
        }
    }

    function printReceipt(){
        var totalAmount = document.querySelector('#totalAmount').innerHTML;
        var cash = document.querySelector('#cash').value;
        var change = document.querySelector('.change').innerHTML;
        var prinLocation = document.querySelector('#print-location');
        prinLocation.href = "print_receipt.php?totalAmount="+totalAmount+"&cash="+cash+"&change="+change;
        window.location.href="print_receipt.php?totalAmount="+totalAmount+"&cash="+cash+"&change="+change;
    }
</script>

<?php
//All Sessions Variable
$_SESSION['total-amount'] = $totalAmount;
$_SESSION['current-sale'] = $sales_row['Sales'];
?>

</body>
</html>