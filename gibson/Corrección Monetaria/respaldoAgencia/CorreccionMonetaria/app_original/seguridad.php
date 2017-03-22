<?
    
    include("conexion.php");
    if(!(isset($_COOKIE["cook_log"])&&isset($_COOKIE["cook_nom"])&&isset($_COOKIE["cook_rol"]))){
        echo "<script>document.location.replace('login.php')</script>";
        end();
    }
    $laPag = split("/",$_SERVER['PHP_SELF']);
    /*
    echo "
    <input type='button' value='Crear usuario' style='margin-top:2px;font:normal normal 8pt tahoma;border:1px solid silver;width:120px;height:20px;position:absolute;bottom:35px;right:156px' onclick='document.location.replace(".chr(34)."usuario.php".chr(34).")'>
    <input type='button' value='Cerrar sesión' style='margin-top:2px;font:normal normal 8pt tahoma;border:1px solid silver;width:120px;height:20px;position:absolute;bottom:35px;right:35px' onclick='document.location.replace(".chr(34)."logout.php".chr(34).")'>";
    */
    //echo "<img src='images/help.jpg' style='position:absolute;bottom:42px;right:42px' onclick='window.open(".chr(34)."help.php?URL=".$laPag[1].chr(34).",".chr(34)."help".chr(34).",".chr(34)."height=350,width=100,status=no,menubar=no,resizable=no,scrollbars=yes,toolbar=no,location=no,directories=no,top=230,left=240".chr(34).")'>";
?>
