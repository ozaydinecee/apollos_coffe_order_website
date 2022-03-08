<?php
require_once('database.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Coffe Image</th>
      <th scope="col">Coffee Name</th>
      
      
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
      <td><a href="?islem=resimduzenle&id=<?=$row["id"];?>">Edit</button></td>
      <a class="btn btn-secondary" href="?islem=resimduzenle&id=<?=$row["id"];?>">Güncelle</a>

      <td><button type="button"href="?islem=sil&id=<?=$row["id"];?>">Delete</button></td>
    </tr>
    <?php
    }?>
    
  </tbody>
</table>
<?php
 
?>

</body>
</html>