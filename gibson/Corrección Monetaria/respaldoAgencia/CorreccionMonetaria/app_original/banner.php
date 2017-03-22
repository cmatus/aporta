<?php
    //phpinfo();
    $lsSRV_Pag = $_SERVER["PATH_INFO"];
    $laSRV_Pag = split("/",$lsSRV_Pag);
    $lsSRV_Pag = $laSRV_Pag[count($laSRV_Pag)-1];
?>
