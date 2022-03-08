<?php
session_start();
require_once('database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Details</title>
</head>
<body>
    <center><p>Thank you for choosing us..</p>
       <!--customerdan çek-->
       <div class="row">
       <div class="col">
                 <p>Order Detail</p>
            </div>
           <div class="col">
                 <p><?=$_SESSION["Customer"]["FirstName"]?> <?=$_SESSION["Customer"]["LastName"]?></p>
            </div>
       <!--orderitemdan çek-->
       
       <?php
        $row = $conn->query("
          SELECT
          orderitem.*,
          coffe.name As CoffeeName
          FROM
          orderitem
          LEFT JOIN coffe ON coffe.CoffeeID = orderitem.CoffeeID
          WHERE
          orderitem.OrderItemId = '{$_GET["orderitem"]}'
        ")->fetch(PDO::FETCH_ASSOC);
 
        $price = $conn->query("SELECT cost FROM size WHERE CoffeeID = '{$row["CoffeeID"]}' AND type = '{$row["type"]}'")->fetch(PDO::FETCH_ASSOC);
          $price = ($price["cost"] * $row["quantity"]) . " TL";
       ?>    
           <div class="col">
                 <p> Coffe :<?=$row["CoffeeName"]?></p>
                </div>
            <div class="col">
                 <p>Type :<?=$row["type"]?></p>
            </div>
            <div class="col">
                 <p>Quantity :<?=$row["quantity"]?></p>
            </div>
            <div class="col">
                 <p>Order No :<?=$row["OrderID"]?></p>
            </div>
            <div class="col">
                 <p>Address :<?=$_SESSION["Customer"]["StreetAddress"]?></p>
            </div>
            <?php
             $row = $conn->query("SELECT * FROM customerorder WHERE OrderID = '{$_GET["custumorder"]}'")->fetch(PDO::FETCH_ASSOC);
       ?>  
            <div class="col">
                 <p>Delivery Time :<?=$row["DeliveryTime"]?></p>
            </div>
            <div class="col">
                 <p>Date :<?=$row["Date"]?></p>
            </div>
            <div class="col">
                 <p>Price :<?=$price?></p>
            </div>
            <a class="btn btn-light" href="index.php">Home Page</a>
    </div></center>
</body>
</html>