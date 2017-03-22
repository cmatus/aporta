<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    include("createzip.php");
    
    define('FPDF_FONTPATH','fpdf/font/');
    require('fpdf/fpdf.php');
    
    $lsTipo = $HTTP_GET_VARS["TIP"];
    
    $lsSQL = "sp907610004_cmm_libroexistencias @planta = 'CL90', @mes = '".trim($lsAno)."01'";
    $result = mssql_query($lsSQL);
    while($row = mssql_fetch_array($result)){
    }
    
?>
