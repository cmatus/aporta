<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("conexion.php");
    set_time_limit(0);
    
    echo "
    <style>
    p{text-align:justify;font-family:tahoma;font-size:8pt}
    li{text-align:justify;font-family:tahoma;font-size:8pt}
    </style>";
    
    $lsURL = $HTTP_GET_VARS["URL"];
    switch($lsURL){
        case "cor010100.php":
            echo "<p><b>Descripci&oacute;n:</b><br>Registros del libro de existencias cargado desde SAP cuyos movimientos de tipo 101 no poseen registro del campo Referencia.<br><br><b>Soluci&oacute;n:</b><br>En la opción Existencias/Carga planilla Excel se debe subir un archivo Excel comprimido en formato ZIP donde coincidan los campos Códito artículo, Planta y Cod. Proveedor con las siguientes columnas:<br><b>·</b>&nbsp;Plant<br><b>·</b>&nbsp;Mat. doc.<br><b>·</b>&nbsp;Reference<br><b>·</b>&nbsp;Material<br><b>·</b>&nbsp;SLoc<br><b>·</b>&nbsp;User<br><b>·</b>&nbsp;Material description<br><b>·</b>&nbsp;Name 1<br><b>·</b>&nbsp;MvtTypeTxt<br><b>·</b>&nbsp;Item<br><b>·</b>&nbsp;CoCd<br><b>·</b>&nbsp;Time<br><b>·</b>&nbsp;PO<br><b>·</b>&nbsp;Item<br><b>·</b>&nbsp;Mvt<br><b>·</b>&nbsp;Cns<br><b>·</b>&nbsp;Rec<br><b>·</b>&nbsp;Vendor<br><b>·</b>&nbsp;MatYr<br><b>·</b>&nbsp;D/C<br><b>·</b>&nbsp;TETy<br><b>·</b>&nbsp;Bill of lading<br><b>·</b>&nbsp;Pstg date<br><b>·</b>&nbsp;Amount in LC<br><b>·</b>&nbsp;Doc. date<br><b>·</b>&nbsp;Quantity<br><b>·</b>&nbsp;Entry date<br></p>";
            break;
        case "cor010200.php":
            echo "<p><b>Descripci&oacute;n:</b><br>Registros del libro de existencias cargado desde SAP cuyos movimientos de tipo 101 poseen registro del campo Referencia pero este no existe en SLI.<br></br><b>Soluci&oacute;n:</b><br>Ubicar las operaciones y cambiar por la referencia correspondiente modificando el valor de esta mediante el punto anterior. Si el valor de la referencia está correcto y aún así aparece como inconsistencia, se puede deber a tres cosas:<br><b>·</b>&nbsp;La referencia no está correcta<br><b>·</b>&nbsp;El código del proveedor no es el correcto<br><b>·</b>&nbsp;Stein no ha recibido factura de proveedor</p>";
            break;
        case "cor010300.php":
            echo "<p><b>Descripci&oacute;n:</b><br>El registro SAP de libro de existencia tiene referencia, esta se encuentra en SLI pero no tiene embaraque asociado en el sistema COMEX.<br></br><b>Soluci&oacute;n:</b><br>Cada división es responsable de asociar correctamente las facturas de proveedor a sus respectivos embarques, por ello las soluciones son:<br><b>·</b>&nbsp;Asociar la factura al embarque<br><b>·</b>&nbsp;Asociar la factura al embarque postal<br><b>·</b>&nbsp;Anular la factura</p>";
            break;
        case "cor010400.php":
            echo "<p><b>Descripci&oacute;n:</b><br>El registro SAP de libro de existencia tiene referencia, esta se encuentra en SLI, tiene embaraque asociado en el sistema COMEX, pero no existe despacho asociado en la agencia de aduanas.<br></br><b>Soluci&oacute;n:</b><br>El responsable en la agencia de aduanas debe asociar correctamente el embarque al despacho correspondiente mediante la referencia, esto debe hacerse tanto en la apertura como en la factura de agencia (si es que ya fue facturado).</p>";
            break;
        case "cor010500.php":
            echo "<p><b>Descripci&oacute;n:</b><br>(PM) = Pro-memoria, corresponde a las facturas que han llegado en el año de proceso que no están en el libro de existencias extraído desde SAP.</p>";
            break;
        case "cor010600.php":
            echo "<p><b>Descripci&oacute;n:</b><br>(PM) = Pro-memoria, corresponde a los embarques que no tienen factura asociada.</p>";
            break;
        case "cor010700.php":
            echo "<p><b>Descripci&oacute;n:</b><br>Facturas que fueron recepcionadas electrónicamente en la agencia de aduanas pero sin fecha, recordemos que con la fecha de la factura se puede estipular el tipo de cambio.<br></br><b>Soluci&oacute;n:</b><br>Se debe subir un archivo Excel con la información faltante.</p>";
            break;
        case "cor010800.php":
            echo "<p><b>Descripci&oacute;n:</b><br>Facturas que fueron recepcionadas electrónicamente en la agencia de aduanas pero sin su moneda, recordemos que con la moneda de la factura se puede estipular el tipo de cambio.<br></br><b>Soluci&oacute;n:</b><br>Se debe subir un archivo Excel con la información faltante.</p>";
            break;
    }
    
?>
