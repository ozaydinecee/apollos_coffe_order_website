<?php
   require_once('database.php');
   
   
   //    if($_SESSION["login"]==false){
   //       ob_start();
   //       header("Refresh: 1; url=login.php");
   //       die( "Bu sayfayı görüntüleme yetkiniz yoktur.");
   //      }
   
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST'){

     if($_GET["islem"] == "veriekle"){
       
     
      $name = $_POST['name']; 
                 
             
     // Veri alanlarının boş olmadığını kontrol ettiriyoruz. başka kontrollerde yapabilirsiniz.
     if ($name <> "" && isset($_FILES['img'])) {
         
         if (isset($_FILES['img'])) {
            $hata = $_FILES['img']['error']; //dosya inputundan gönderilen hatayı aldık.
            if ($hata != 0) { // hata kontrolü gerçekleştirdik.
                  echo 'Dosya gönderilirken bir hata gerçekleşti.';
            } else {
                  $dosyaBoyutu = $_FILES['img']['size']; // dosya boyutunu öğrendik
                  if ($dosyaBoyutu > (1024 * 1024 * 4)) {
                     //buradaki işlem aslında bayt, kilobayt ve mb formülüdür.
                     //2 rakamını mb olarak görün ve kaç yaparsanız o mb anlamına gelir.
                     //Örn: (1024 * 1024 * 3) => 3MB / (1024 * 1024 * 4) => 4MB
         
                     echo 'Dosya 2MB den büyük olamaz.';
                  } else {
                     $dosyaAdi = $_FILES['img']['name']; //resmin adını öğrendik.
         
                     $uzantisi = explode('.', $dosyaAdi); // uzantısını öğrenmek için . işaretinden parçaladık.
                     $uzantisi = $uzantisi[count($uzantisi) - 1]; // ve daha sonra 1 den fazla nokta olma ihtimaline karşı en son noktadan sonrasını al dedik.
         
                     $yeni_adi = time() . "." . $uzantisi; // dosyaya yeni isim vereceğimiz için zamana göre yeni bir isim oluşturduk ve yüklemesi gerektiği yeride belirttik.

                     //yuklenecek_yer/dosya_adi.uzantisi.
                     if (move_uploaded_file($_FILES["img"]["tmp_name"], "assets/img/coffe&pleasures/".$yeni_adi)) {
                        //tmp_name ile dosyayı bulduk ve $yeni_adi değişkeninin değerine göre yükleme işlemini gerçekleştirdik.
                        echo "Dosya başarılı bir şekilde yüklendi.";
                     } else echo 'Dosya yüklenirken bir hata oluştu.';
                  }
            }
         }

         $satir = [
            'img' => $yeni_adi,
            'name' => $name,

        ];

         $sql = "INSERT INTO coffe SET img=:img, name=:name";
         $durum = $conn->prepare($sql)->execute($satir);
         if ($durum) { 
            header("Location: duzenle.php?islem=liste&situation=ok");
         } else {
            header("Location: duzenle.php?islem=liste&situation=no");
         }
   

     }
   }
    
     }
     
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Administration Form</title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500&display=swap">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <link rel="stylesheet" href="assets/css/style.css">
      <link rel="stylesheet" href="assets/css/bootstrap.css">
   </head>
   <body>

      <?php
         switch(@$_GET["islem"]) {
           case "resimekle":
         ?>

      <form action="?islem=veriekle" method="post" enctype="multipart/form-data">
         <div class="container">

            <div class="form-group">
               <label for="exampleFormControlFile1">Add img :</label>
               <input type="file" name="img" class="form-control-file" id="exampleFormControlFile1">
            </div>

            <div class="form-group">
               <label for="exampleInputPassword1">Coffe Name:</label>
               <input type="text" name="name" class="form-control" id="exampleInputPassword1" placeholder="Name">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
         </div>
      </form>

      <?php
         break;
         case "liste":
         ?>
      <table class="table">

         


        

         <thead class="thead-dark">
            <tr>
               <th scope="col">Coffe Image</th>
               <th scope="col">Coffee Name</th>
               <th><a class="btn btn-success" href="?islem=resimekle" > Add Coffee </a></th>

            </tr>
         </thead>

         <tbody>
            <?php                       
               $sorgu = $conn->query("SELECT * FROM coffe");
                   foreach ($sorgu as $row) {
               ?>
            <tr>
               <td class="kücült"><img src="assets/img/coffe&pleasures/<?=$row["img"]?>" alt=""></td>
               <td><?=$row["name"]?></td>
              
            </tr>
            <?php
               }?>
         </tbody>
      </table>

      <?php
         default:
            // header("Location: ?islem=liste");
         break;
         }
         ?>

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
      </div>
      </div>
      <script type="text/javascript" src="../js/sweetalert.min.js"></script>
      <script src="../../vendors/base/vendor.bundle.base.js"></script>
      <script src="../../js/off-canvas.js"></script>
      <script src="../../js/hoverable-collapse.js"></script>
      <script src="../../js/template.js"></script>
   </body>
</html>