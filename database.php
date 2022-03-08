<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dataname = "coffe_order"; 
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dataname", $username, $password);
        $conn->exec("set names utf8");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";


        


    } catch(PDOException $e) {
        //echo "Connection failed: ". $e->getMessage();
    }

?>

