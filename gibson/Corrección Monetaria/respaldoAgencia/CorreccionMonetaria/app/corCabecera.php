<?php
    
    //$lsSQL = "select * from [907610004_cmm_opcion] OPC inner join [907610004_cmm_opcionrol] ROL ON OPC.id = ROL.id_opcion WHERE ROL.id_rol = ".trim($_COOKIE["cook_rol"])." ORDER BY OPC.orden";
    $lsSQL = "select * from [907610004_cmm_opcion] ORDER BY orden";
    $stmt = sqlsrv_query($conn, $lsSQL);
    
    echo "
    <table cellpadding=0 cellspacing=0>
    <tr style='height:21px'>
    <td style='width:35px'><img src='images/topnav_border_left.gif' /></td>";
    
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        if(substr($lsSRV_Pag,0,5)==trim($row["pagina"])){
            echo "<td background='images/topnav_bg_on.gif' style='border-left:1px solid silver;color:gray;text-align:center;font:bold bold 8pt tahoma;width:150px'>&nbsp;".trim($row["opcion"])."&nbsp;</td>";
        } else{
            echo "<td background='images/topnav_bg.gif' onmouseover='this.background=".chr(34)."images/topnav_bg_on.gif".chr(34)."' onmouseout='this.background=".chr(34)."images/topnav_bg.gif".chr(34)."' style='cursor:hand;border-left:1px solid silver;color:gray;text-align:center;font:normal normal 8pt tahoma;width:150px' onclick='document.location.replace(".chr(34).trim($row["pagina"])."0100.php".chr(34).")'>&nbsp;".trim($row["opcion"])."&nbsp;</td>";
        }
    }
    
    echo "
    <td style='width:35px'><img src='images/topnav_border_right.gif' /></td>
    </tr>
    </table>";
    
?>
