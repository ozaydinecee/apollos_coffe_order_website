<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<?php
   require_once("checklogin.php");
   require_once('../database.php');
   require_once("interface.php");


   if($_SESSION["login"]==false){
      ob_start();
      header("Refresh: 1; url=login.php");
      die( "Bu sayfayı görüntüleme yetkiniz yoktur.");
     }


   if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
     if($_GET["islem"] == "resimekle"){
       
     // resim ekle
     $isim = $_POST['isim']; 
     $paragraph = $_POST['paragraph'];
                 
             
     // Veri alanlarının boş olmadığını kontrol ettiriyoruz. başka kontrollerde yapabilirsiniz.
     if ($isim <> "" && $paragraph <> "" && isset($_FILES['photo'])) {
   
         if ($_FILES['photo']['error'] != 0) {
             $hata .= 'Dosya yüklenirken hata gerçekleşti lütfen daha sonra tekrar deneyiniz.';
         } else {
   
             $dosya_adi = strtolower($_FILES['photo']['name']);
             if (file_exists('images/' . $dosya_adi)) {
                 $hata .= " $dosya_adi diye bir dosya var";
             } else {
                 $boyut = $_FILES['photo']['size'];
                 if ($boyut > (1920 * 1080 * 20)) {
                     $hata .= ' Dosya boyutu 20MB den büyük olamaz.';
                 } else {
                     $dosya_tipi = $_FILES['photo']['type'];
                     $dosya_uzanti = explode('.', $dosya_adi);
                     $dosya_uzanti = $dosya_uzanti[count($dosya_uzanti) - 1];
   
                     if (!in_array($dosya_tipi, ['image/png', 'image/jpeg']) || !in_array($dosya_uzanti, ['png', 'jpg'])) {
                         //if (($dosya_tipi != 'image/png' || $dosya_uzanti != 'png' )&&( $dosya_tipi != 'image/jpeg' || $dosya_uzanti != 'jpg')) {
                         $hata .= ' Hata, dosya türü JPEG veya PNG olmalı.';
                     } else {
                         $photo = $_FILES['photo']['tmp_name'];
                         copy($photo, '../uploads/' . $dosya_adi);
   
   
                         //Eklencek veriler diziye ekleniyor
                         $satir = [
                             'photo' => $dosya_adi,
                             'isim' => $isim,
                             'paragraph' => $paragraph,                                     
                         ];
   
                         // Veri ekleme sorgumuzu yazıyoruz.
                         $sql = "INSERT INTO sliderr SET photo=:photo, isim=:isim,paragraph=:paragraph";
                         $durum = $conn->prepare($sql)->execute($satir);
                         if ($durum) {
                          echo '<script>swal("Başarılı","Slider Eklendi","success").then((value)=>{ window.location.href = "slider.php?islem=liste"});
            
                          </script>';
                                                  }
   
   
                     }
                 }
             }
         }
     }
     if($hata!=""){
         echo '<script>swal("Hata","'.$hata.'","error");</script>';
     }
   }
    
     }
     
     if($_GET["islem"] == "postresimduzenle"){
     
       
     $isim = $_POST['isim']; 
     $paragraph = $_POST['paragraph'];
   
   
             
     // Veri alanlarının boş olmadığını kontrol ettiriyoruz. başka kontrollerde yapabilirsiniz.
     if ($isim <> "" && $paragraph <> "" && isset($_FILES['photo'])) {
   
         if ($_FILES['photo']['error'] != 0) {
             $hata .= 'Dosya yüklenirken hata gerçekleşti lütfen daha sonra tekrar deneyiniz.';
         } else {
   
             $dosya_adi = strtolower($_FILES['photo']['name']);
             if (file_exists('uploads/' . $dosya_adi)) {
                 $hata .= " $dosya_adi diye bir dosya var";
             } else {
                 $boyut = $_FILES['photo']['size'];
                 if ($boyut > (1920 * 1080 * 20)) {
                     $hata .= ' Dosya boyutu 20MB den büyük olamaz.';
                 } else {
                     $dosya_tipi = $_FILES['photo']['type'];
                     $dosya_uzanti = explode('.', $dosya_adi);
                     $dosya_uzanti = $dosya_uzanti[count($dosya_uzanti) - 1];
   
                     if (!in_array($dosya_tipi, ['image/png', 'image/jpeg']) || !in_array($dosya_uzanti, ['png', 'jpg'])) {
                         //if (($dosya_tipi != 'image/png' || $dosya_uzanti != 'png' )&&( $dosya_tipi != 'image/jpeg' || $dosya_uzanti != 'jpg')) {
                         $hata .= ' Hata, dosya türü JPEG veya PNG olmalı.';
                     } else {
                         $photo = $_FILES['photo']['tmp_name'];
                         copy($photo, '../uploads/' . $dosya_adi);
   
                         // Veri güncelleme sorgumuzu yazıyoruz.
                        $conn->query("UPDATE sliderr SET photo='{$dosya_adi}', isim='{$isim}', paragraph='{$paragraph}' WHERE id='{$_GET["id"]}'");
    
                       
                         if ($conn) {
                           echo '<script>swal("Başarılı","Slider Eklendi","success").then((value)=>{ window.location.href = "slider.php?islem=liste"});
            
                           </script>';
                                                  }
   
   
                     }
                 }
             }
         }
     }
     if($hata!=""){
         echo '<script>swal("Hata","'.$hata.'","error");</script>';
     }
   }
  
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?=head("Anasayfa")?>
   </head>
   <body>
      <div class="container-scroller">
         <?=topmenu()?>
         <div class="container-fluid page-body-wrapper">
            <?=leftmenu()?>
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">
                  <div class="row">
                     <?php
                        switch(@$_GET["islem"]) {
                          case "resimekle":
                        ?>
                     <div class="main-panel">
                        <div class="content-wrapper">
                           <div class="row">
                              <div class="col-12 grid-margin stretch-card">
                                 <div class="card">
                                    <div class="card-body">
                                       <h4 class="card-title">Slider Yönetimi</h4>
                                       <p class="card-description">
                                          Slider Ekle
                                       </p>
                                       <form action="slider.php?islem=resimekle" method="post" enctype="multipart/form-data">
                                          <div class="row">
                                             <div class="form-group">
                                                <label>Resim</label>
                                                <!--resim-->
                                                <input type="file" name="photo" class="form-control" style="margin-left: 3%">
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label >Başlık</label>
                                             <!--baslik-->
                                             <input type="text" class="form-control"  name="isim" placeholder="Başlık">
                                          </div>
                                          <div class="form-group">
                                             <label >Açıklama</label>
                                             <!--acıklama-->
                                             <textarea class="form-control" name="paragraph"  rows="8" placeholder="Açıklama"></textarea>
                                          </div>
                                          <!--acıklama
                                             <input type="submit" value="Kaydet"class="btn btn-primary mr-2"  name="submit" placeholder="Açıklama">-->
                                          <button class="btn btn-primary mr-2"  type="submit">Kaydet</button>
                                          <!--<button type="submit" class="btn btn-primary mr-2">Kaydet</button>-->
                                          <a class="btn btn-light" href="slider.php?islem=liste">İptal</a>
                                    </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php
                        break;
                        case "resimduzenle";
                        ?>
                     <?php
                        $oku = $conn->query("SELECT * FROM sliderr WHERE id='{$_GET["id"]}'")->fetch(PDO::FETCH_ASSOC);
                        ?>
                     <div class="main-panel">
                        <div class="content-wrapper">
                           <div class="row">
                              <div class="col-12 grid-margin stretch-card">
                                 <div class="card">
                                    <div class="card-body">
                                       <h4 class="card-title">Slider Yönetimi</h4>
                                       <p class="card-description">
                                          Slider Ekle
                                       </p>
                                       <form action="?islem=postresimduzenle&id=<?=$oku["id"]?>" method="post" enctype="multipart/form-data">
                                          <div class="row">
                                             <div class="form-group">
                                                <label>Resim</label> <br>
                                                <!--resim-->
                                                <a href="../uploads/<?=$oku["photo"]?>"><img src="../uploads/<?=$oku["photo"]?>" style="max-width:50%;" alt=""></a>
                                                <input type="file" name="photo" class="form-control"  >
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label >Başlık</label>
                                             <!--baslik-->
                                             <input type="text" class="form-control" value="<?=$oku["isim"]?>" name="isim" placeholder="Başlık">
                                          </div>
                                          <div class="form-group">
                                             <label >Açıklama</label>
                                             <!--acıklama-->
                                             <textarea class="form-control" name="paragraph"  rows="8" > <?=$oku["paragraph"]?></textarea>
                                          </div>
                                          <!--acıklama-->
                                          <input type="submit" value="Kaydet"class="btn btn-primary mr-2"  name="submit" placeholder="Açıklama">
                                          <!--<button type="submit" class="btn btn-primary mr-2">Kaydet</button>-->
                                          <button class="btn btn-light">İptal</button>
                                    </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php
                        break;
                        case "liste";
                        ?>
                     <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="card-title">Veri Listemiz</h4>
                              <a class="btn btn-success" href="slider.php?islem=resimekle">Veri Ekle</a>
                              <div class="table-responsive">
                                 <table class="table table-striped">
                                    <thead>
                                       <tr>
                                          <th> Fotoğraflar </th>
                                          <th> İsimler </th>
                                          <th> Açıklamalar </th>
                                          <th> </th>
                                          <th> </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php 
                                          $db = $conn->query("SELECT * FROM sliderr ORDER BY id ASC");
                                          $oku = $db->fetchAll(PDO::FETCH_ASSOC);
                                          
                                          foreach ($oku as $row) {
                                          
                                          ?>
                                       <tr>
                                          <td class="py-1">
                                             <img src="../uploads/<?=$row["photo"];?>" alt="image">
                                          </td>
                                          <td >
                                             <?=$row["isim"];?>
                                          </td>
                                          <td>
                                             <?=$row["paragraph"];?>
                                          </td>
                                          <td  >
                                             <a class="btn btn-secondary" href="?islem=resimduzenle&id=<?=$row["id"];?>">Güncelle</a>
                                          </td>
                                          <td >
                                             <a class="btn btn-danger" href="?islem=sil&id=<?=$row["id"];?>">Sil</a>
                                          </td>
                                       </tr>
                                       <?php
                                          }
                                          
                                          ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php
                        break;
                        case "sil";
                        ?>
                     <?php 
                        $sql=$conn->query("DELETE FROM sliderr WHERE id='{$_GET["id"]}'");
                        
                        if ($sql->rowCount() > 0) {
                           echo '<script>swal("Başarılı","Silindi","success").then((value)=>{ window.location.href = "slider.php?islem=liste"});
                        </script>';
                        } else {
                            echo "Herhangi bir kayıt silinemedi.";
                        }
                        ?>
                     <?php
                        default:
                        //echo"nasıl default vermeliyim?";
                        break;
                        }
                        ?>
                  </div>
               </div>
               <?=footer()?>
            </div>
         </div>
      </div>
      <script src="../../vendors/base/vendor.bundle.base.js"></script>
      <script src="../../js/off-canvas.js"></script>
      <script src="../../js/hoverable-collapse.js"></script>
      <script src="../../js/template.js"></script>
   </body>
</html>