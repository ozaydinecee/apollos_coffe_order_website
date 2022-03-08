<?php

require_once('database.php');

            if(isset($_POST['submitted'])){
                $FirstName = $_POST['FirstName'];
                $LastName = $_POST['LastName'];
                $EMailAddress = $_POST['EMailAddress'];
                $Password = $_POST['Password'];
                $Town = $_POST['Town'];
                $PostCode = $_POST['PostCode'];
                $StreetAddress = $_POST['StreetAddress'];
                //generates randomly customerID
                $CustomerID = rand(10000,99999);
                //email-validation

                $emailCheck = $conn->query("SELECT COUNT(*) As Kontrol FROM customer WHERE EMailAddress = '{$EMailAddress}'")->fetch(PDO::FETCH_ASSOC);
                if( $emailCheck["Kontrol"] == 0 )
                {
                    $insert = $conn->query("INSERT INTO customer (CustomerID,FirstName,LastName,EMailAddress,Password,Town,PostCode,StreetAddress) VALUES ('$CustomerID','$FirstName','$LastName','$EMailAddress','$Password','$Town','$PostCode','$StreetAddress')");
                
                    if ( $insert ){
                        $last_id = $conn->lastInsertId();
                        header("Location:login.php");
                    }
                    else{
                        $message = "Try again";
                    }
                } else {
                    $message = " E-Mail is valid on the system ";
                }
             }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Sign Up</title>
</head>
<body>






<div class="login-page">
  <div class="form">
    <form method="post" class="register-form">
      <input type="text" name="FirstName" placeholder="Name " required/>
      <input type="text" name="LastName" placeholder="Surname " required/>
      <input type="text" name="EMailAddress" placeholder="E-mail " required/>
       <input type="password"name="Password" placeholder="Password" required/>
      <!--<input type="text" name="Town" placeholder="Town " required/>
      <input type="text" name="PostCode" placeholder="Post Code " required/> -->
      <input type="text" name="StreetAddress"placeholder="Select status " required/>
      <!-- <a href="login.php">Create Account</a> -->
      <button type="submit" name="submitted"class="btn btn-info">Submit</button>
      <br>
      <?=@$message?>
      
    </form>

    </div>
</div>








    <script>
  <script src="js/bootstrap.min.js"></script></script>
</body>
</html>