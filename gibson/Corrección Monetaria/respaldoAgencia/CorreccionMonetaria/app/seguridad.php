<?php
    
    include("conexion.php");
    if(!(isset($_COOKIE["cook_log"])&&isset($_COOKIE["cook_nom"])&&isset($_COOKIE["cook_rol"]))){
        echo "<script>document.location.replace('login.php')</script>";
        end();
    }
    $laPag = split("/",$_SERVER['PHP_SELF']);

?>
