<?php
session_start();
ob_start();



require_once('database.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Log In Page</title>
</head>
<body>

<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
  if($_GET["islem"] == "giris_islemi"){
 
  $EMailAddress = $_POST['EMailAddress'];
  $Password = $_POST['Password'];
  //////////////////LOG IN////////////
if ($EMailAddress <> "" && $Password <> "") {
        if(isset($_POST["login"])){
          
          $EMailAddress = $_POST['EMailAddress'];
          $Password = $_POST['Password'];

            $kontrol = $conn->query("SELECT * FROM Customer WHERE EMailAddress = '{$EMailAddress}' AND Password = '{$Password}'")->fetch(PDO::FETCH_ASSOC);
            

              if($kontrol) {
                  //dogru
                  $_SESSION["login"]=true;
                  $_SESSION["CustomerID"]=$kontrol["CustomerID"];
                  $_SESSION["EMailAddress"]=$EMailAddress;
                  $_SESSION["Password"]=$Password;
                  $_SESSION["Customer"]=$kontrol;
                  header("Location:index.php");
                  ?>
                  <?php
              }
              else {
                echo $wrong="Wrong email or password";
               
                header("Refresh: 3; url=login.php");
                //yanlış
              }
         
        }
      }
        else{
          echo "Fill the required area.<br>";
        }
      }
    }
        
    ob_end_flush();
            ?>


<div class="login-page">
  <div class="form">
    <form action="?islem=giris_islemi" class="login-form" method="post">
      <input type="text" name="EMailAddress" placeholder="E-mail" required/>
      <input type="password" name="Password"placeholder="Şifre" required/>
      <button type="submit" name="login">Log In</button>
      <p >Don't you registered? <a href="registration.php">Create Account</a></p>
      <br>
      <?=@$wrong?>
    </form>
  </div>
</div>







    <script>
        $('.message a').click(function(){
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");});
    </script>
    <script>
  <script src="js/bootstrap.min.js"></script></script>
<script type="text/javascript" src="../js/sweetalert.min.js"></script>

</body>
</html>