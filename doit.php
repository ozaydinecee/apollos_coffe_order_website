<?php
switch(@$_GET["action"])
{
    case "Get_Types_For_Coffee":
    {
        require_once('database.php');
        
        $CoffeeID = $_GET["CoffeeID"];

        $getTypes = $conn->query("SELECT * FROM size WHERE CoffeeID = '{$CoffeeID}'")->fetchAll(PDO::FETCH_ASSOC);

        foreach( $getTypes as $type ) {
            ?>
            <option value="<?=$type["type"]?>" class="CurrentTypes"><?=$type["type"]?></option>
            <?php
        }
    } break;
}
?>