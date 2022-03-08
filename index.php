<?php
session_start();
ob_start();
require_once('database.php');

   if(isset($_POST['send'])){
         $DeliveryTime = $_POST['deliverytime'];
         $Date = $_POST['datee'];
         $CustomerId = $_POST['CustomerID'];
      
         $insert = $conn->query("INSERT INTO customerorder (Date,DeliveryTime,CustomerId) VALUES ('$Date','$DeliveryTime','$CustomerId')");
         
         if ( $insert ){
            $customerOrderLastId = $conn->lastInsertId();
            $conn->query("INSERT INTO orderitem (OrderID,CoffeeID,type,quantity) VALUES ('$customerOrderLastId','{$_POST["CoffeeID"]}','{$_POST["TypeID"]}','{$_POST["Quantity"]}')");
            $orderItemLastId = $conn->lastInsertId();
            header("Location: order.php?custumorder={$customerOrderLastId}&orderitem={$orderItemLastId}");
         }
         else{
            //$message = "Tekrar deneyiniz";
         }
      }
?>

<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Apollo's Coffe</title>
      <!--title icon-->
      <link rel = "icon" href =  "assets/img/header.png" type = "image/x-icon">
      <!-- CSS -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500&display=swap">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <link rel="stylesheet" href="assets/css/style.css">

      
      <!-- Favicon and touch icons -->
      <link rel="shortcut icon" href="assets/ico/favicon.png">
      
   </head>
   <body>
   
  


      <!-- Wrapper -->
      <div class="wrapper">
         <!-- Sidebar -->
         <nav class="sidebar" style="left:-255px">
            <!-- close sidebar menu -->
            <div class="dismiss">
               <i class="fas fa-arrow-left"></i>
            </div>
            <div >
               <h3><a href="index.html"><img src="assets/img/apollologo.png" alt=""></a></h3>
            </div>
            <ul class="list-unstyled menu-elements">
               <li class="active">
                  <a class="scroll-link" href="#section-1"><i class="fas fa-user"></i>About Us</a>
               </li>
               <li>
                  <a class="scroll-link" href="#section-2"><i class="fa fa-coffee" ></i> Menu</a>
               </li>
               <li>
                  <a class="scroll-link" href="#section-3"><i class="fas fa-shopping-cart"></i> Give Order</a>
               </li>
               <?php
                           if( isset($_SESSION["login"]) )
                           {
                              if( $_SESSION["login"] == true )
                              {
                                 if( $_SESSION["Customer"]["Status"] == "NORMAL" )
                                 {
                                    //  didn see anything .only admin can see administration form
                                 }
                                 if( $_SESSION["Customer"]["Status"] == "YETKILI" )
                                 {
                                    ?>
                                    <li>
                                       <a class="scroll-link" href="duzenle.php?islem=liste"><i class="fas fa-user"></i> Administration</a>
                                    </li>
               
                                    <?php
                                 }
                              }
                           }
                           ?>
               
               <li>
                  <a class="scroll-link" href="#section-4"><i class="fas fa-user"></i> Mostly Orders</a>
               </li>
              
            </ul>
         </nav>
         <!-- End sidebar -->
         
         <!-- Content -->
         <div class="content">
            <?php
            $loginKontrol = false;
            if( isset($_SESSION["login"]) )
            {
               if( $_SESSION["login"] == true ) $loginKontrol = true;
               else $loginKontrol = false;
            } else
               $loginKontrol = false;

            if( !$loginKontrol ) {
            ?>
             <a class="btn btn-secondary  btn-customized-2 login-menu" href="login.php" role="button">Log in</a>
            <a class="btn btn-primary btn-customized signup-menu" href="registration.php" role="button">Sign Up</a>
            <?php } else { ?>
               <a class="btn btn-secondary  btn-customized-2 login-menu" href="logout.php" role="button">Log Out</a>
               <?php } ?>
            <!--open sidebar menu -->
            <a class="btn btn-primary btn-customized open-menu" href="#" role="button">
            <i class="fas fa-align-left"></i> <span>Menu</span>
            </a>
            <!-- Section 1 ABOUT US -->
            <div class="section-1-container section-container section-container-gray-bg" id="section-1">
               <div class="container">
                  <div class="row">
                     <div class="col section-1 section-description">
                     </div>
                  </div>

                  <center><h3 class="username"> <?php
                           if( isset($_SESSION["login"]) )
                           {
                              if( $_SESSION["login"] == true )
                              {
                                 if( $_SESSION["Customer"]["Status"] == "NORMAL" )
                                 {
                                    echo "Hi, welcome Customer";
                                 }
                                 if( $_SESSION["Customer"]["Status"] == "YETKILI" )
                                 {
                                    echo "Hi, welcome Admin!";
                                 }
                              }
                           }
                           ?>
                  </h3>
                  </center>
                  <div class="row">
                 
                     <div class="col-8 section-1-box ">
                        <h3 style="margin-left:0px;">
                           About Us
                        </h3>
                        <p class="medium-paragraph">
                           Our story begins in 1971 along the cobblestone streets of Seattle’s historic Pike Place Market. 
                        </p>
                        <p>
                           It was here where Apollo opened its first store, offering fresh-roasted coffee beans,
                           tea and spices from around the world for our customers to take home. Our name was inspired
                           by the classic tale, “Moby-Dick,” evoking the seafaring tradition of the early coffee traders.
                        </p>
                     </div>
                     <div class="col-4 section-1-box  ">
                        <img src="assets/img/aboutus.png" alt="about-us">
                     </div>
                  </div>
               </div>
            </div>
            <!-- Section 2 coffes and pleasures -->
            <div class="section-2-container container section-container" id="section-2">
               <div class="container">
                  <div class="row">
                     <div class="col section-2 section-description  ">
                        <h2>Coffee &amp; Pleasures</h2>
                        <div class="divider-2  "><span></span></div>
                     </div>
                  </div>
                  <div class="row "><?php
                            
                            
                            $sorgu = $conn->query("SELECT * FROM coffe");
                             foreach ($sorgu as $row) {
 
                         ?>
                     <div class="col-md-3 section-2-box  ">
                     
                        <div class="row">
                           <div class="col">
                              <figure>
                                 <div class="section-2-box ">
                                    <img src="assets/img/coffe&pleasures/<?=$row["img"]?>" alt="">
                                 </div>
                              </figure>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col ">
                              <h3><?=$row["name"]?></h3>
                              
                           </div>
                        </div>
                        
                     </div><?php
                             }
                         ?>
                  </div>
               </div>
            </div>
            <!-- Section 3 GIVE ORDER -->
            <div class="section-2-container section-container section-container-gray-bg" id="section-3">
               <div class="container">
                  <div class="row">
                     <div class="col section-2 section-description  ">
                        <div class="divider-2 "><span></span></div>
                     </div>
                  </div>
                  <div class="row ">
                     <div class="col-md-6">
                        <img class="orderimg  " src="assets/img/order.jpg" width="300px" alt="">
                     </div>
                     <div class="col-md-6">
                        <h3><span class="username"><?=isset($_SESSION["Customer"]["FirstName"])?$_SESSION["Customer"]["FirstName"]:'Guest'?></span>	,give order now!</h3>
                        <div class="main-block">
                           <form action="/?c=1" method="POST">
                              <input type="hidden" name="CustomerID" value="<?=@$_SESSION["CustomerID"]?>">
                              <div class="info">
                                 <div class="row">
                                    <div class="col">
                                       <select  name="CoffeeID" class="CoffeeItem ">
                                          <option value="number" >What you want to drink?</option>
                                          <?php
                                          $drinks = $conn->query("SELECT * FROM coffe ORDER BY CoffeeID")->fetchAll(PDO::FETCH_ASSOC);

                                          foreach( $drinks as $drink ) {
                                          ?>
                                          <option value="<?=$drink["CoffeeID"]?>"><?=$drink["name"]?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                    <div class="col">
                                       <select name="TypeID" class="Types">
                                          <option value="number" name disabled selected> Type</option>
                                       </select>
                                    </div>
                                    <div class="col">
                                       <select name="Quantity">
                                          <option value="number" disabled selected> Quantity</option>
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5</option>
                                          <option value="6">6</option>
                                       </select>
                                    </div>
                                    
                                    
                                    <div class="col">
                                       <label for=""> Choose Delivery Time:</label>
                                       <input type="time" name="deliverytime" class="DeliveryTime" >
                                       
                                    </div>
                                    <div class="col">
                                       
                                       <label for=""> Choose Delivery Date:</label>
                                       <input type="date" name="datee" class="DeliveryDate" >
                                    </div>
                                    
                                 </div>
                                 <div class="row">
                                 <div class="col">
                                    <?php
                                    if( isset($_SESSION["login"]) )
                                    {
                                       if( $_SESSION["login"] == true )
                                       {
                                          // giriş yaptı
                                          //echo "You can give order..";
                                          ?>
                                             <button class="btn btn-secondary btn-customized-2 " name ="send" type="submit">I want it</button>
                                          <?php
                                       } else {
                                          // giriş yapmadı
                                          echo "Sıgn up or Log ın to give order..";
                                       }
                                    } else {
                                       // giriş yapmadı
                                       echo "Sıgn up or Log ın to give order..";
                                    }
                                    ?>
                                    </div>
                                    </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
         </div>
         <div class="section-2-container section-container" id="section-4">
            <div class="container">
               <div class="row">
                  <div class="col section-2 section-description  ">
                     <h2>Mostly Orders</h2>
                     <?php
                            
                            
                            $enCokSiparisVerilenKahve = $conn->query("
                            SELECT
                            COUNT(orderitem.CoffeeID) As Toplam,
                            coffe.name
                            FROM
                            orderitem
                            LEFT JOIN coffe ON coffe.CoffeeID = orderitem.CoffeeID
                            GROUP BY orderitem.CoffeeID
                            ORDER BY Toplam DESC
                            LIMIT 10
                            ")->fetchAll(PDO::FETCH_ASSOC);
                         ?>
                     <div class="row ">
                        
                        <div class="col-md-12 ">
                           <?php
                            foreach( $enCokSiparisVerilenKahve as $row ) {
                               ?>
                           <h3 class="username"><?=$row["name"]?> was chosen <span class="boldusername"><?=$row["Toplam"]?></span> times.</h3>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Footer -->
         <footer class="footer-container">
            <div class="container">
               <div class="row">
                  <div class="col">
                     &copy; 2021-Designed by <a href="https://www.linkedin.com/in/ece-%C3%B6zayd%C4%B1n-147330207/">ecozaydin</a>.
                  </div>
               </div>
            </div>
         </footer>
      </div>
      <!-- End content -->
      </div>
      <!-- End wrapper -->
      <!-- Javascript -->
      <script src="assets/js/jquery-3.3.1.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      
      <script src="assets/js/jquery.waypoints.min.js"></script>
      
      <script>
         $(document).ready(function(){
            $(".open-menu").click(function(){
               $(".sidebar").css("left", "0");
            });
            $(".dismiss").click(function(){
               $(".sidebar").css("left", "-255px");
            });
            
            $(".CoffeeItem").change(function() {
               $.ajax({
                  type: "GET",
                  url: "doit.php",
                  data: {"action": "Get_Types_For_Coffee", "CoffeeID": $(this).val()},
                  success: function (data)
                  {
                     $(".CurrentTypes").remove();
                     $(".Types").append(data);
                  }
               });
            });
         });
      </script>
   </body>
</html>