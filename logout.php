<?php
    session_start();
    ob_start();

    unset($_SESSION["login"]);
    unset($_SESSION["CustomerID"]);
    unset($_SESSION["EMailAddress"]);
    unset($_SESSION["Password"]);
    unset($_SESSION["Customer"]);

    session_destroy();
    echo "Logged out. You are being redirected to the home page.";
    header("Refresh: 0.5; url=index.php");
?>