<?php
    require_once("connection.php");
    $totalAmount = $_GET['totalAmount'];
    $cash = $_GET['cash'];
    $change = $_GET['change'];

    $sql = "SELECT * FROM `pos_database`.`pos_table`";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total = $query->num_rows;

    if($total == 0){
        header("Location:index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Slip</title>
    <link rel="stylesheet" href="css/print_receipt.style.css">
</head>
<body>
    <div class="container">
        <div class="receipt-paper">
            <table>
                <?php
                    if($total > 0){
                        do{
                ?>
                            <tr>
                                <td class="description"><?php echo $row['Description']; ?><br> <?php echo $row['Quantity']; ?> @ &#8369;<?php echo $row['Price']; ?></td>
                                <td class="amount">&#8369;<?php echo $row['Amount']; ?></td>
                            </tr>
                <?php
                        }while($row = $query->fetch_assoc());
                    }
                ?>

                <tr>
                    <td class="total"><strong>Total</strong></td>
                    <td class="total-amount"><strong><?php echo $totalAmount; ?></strong></td>
                </tr>

                <tr>
                    <td class="cash"><em>Cash</em></td>
                    <td class="cash-amount"><em>&#8369;<?php echo $cash; ?></em></td>
                </tr>

                <tr>
                    <td class="change"><em>Change</em></td>
                    <td class="change-amount"><em><?php echo $change; ?></em></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        window.print();
        window.addEventListener('afterprint',function(){
            window.location.href = "index.php";
        });
    </script>
</body>
</html>