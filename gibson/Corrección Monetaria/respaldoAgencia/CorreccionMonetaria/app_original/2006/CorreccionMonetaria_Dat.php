<?php
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
?>
<LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
<script language="JavaScript" type="text/JavaScript" src="http://www.stein.cl/SLI/Include/funciones.js"></script>
<?php
    
    include("../SLI/SLIStandar/conexion.php");
    
    $lsAno = $HTTP_GET_VARS["ANO"];
    
    $lsSQL = "SELECT * FROM DOCUMENTOS..CorreccionMonetaria ORDER BY [Planta],[Artículo]";
    
	$msresults = mssql_query($lsSQL); 
	$msfields  = mssql_num_fields($msresults); 
	$msrows    = mssql_num_rows($msresults);
    
	$lsCampo = array();
	
	$lsCampo[0][0]  = "right";
	$lsCampo[0][1]  = "left";
	$lsCampo[0][2]  = "left";
	$lsCampo[0][3]  = "left";
	$lsCampo[0][4]  = "right";
	$lsCampo[0][5]  = "center";
	$lsCampo[0][6]  = "right";
	$lsCampo[0][7]  = "right";
	$lsCampo[0][8]  = "left";
	$lsCampo[0][9]  = "right";
    $lsCampo[0][10] = "right";
    $lsCampo[0][11] = "right";
    $lsCampo[0][12] = "right";
    $lsCampo[0][13] = "right";
    $lsCampo[0][14] = "right";
    $lsCampo[0][15] = "right";
    $lsCampo[0][16] = "right";
	
    $lsCampo[1][0]  = 80;  //Articulo
    $lsCampo[1][1]  = 80;  //Planta
    $lsCampo[1][2]  = 80;  //Procedencia
    $lsCampo[1][3]  = 80;  //Nº Docto.
    $lsCampo[1][4]  = 80;  //Fecha
    $lsCampo[1][5]  = 80;  //PO
    $lsCampo[1][6]  = 80;  //Referencia
    $lsCampo[1][7]  = 80;  //U.M.
    $lsCampo[1][8]  = 80;  //Cantidad
    $lsCampo[1][9]  = 80;  //Costo (SLI)
    $lsCampo[1][10] = 80;  //Costo (elegido)
    $lsCampo[1][11] = 80;  //Costo (elegido)
    $lsCampo[1][12] = 80;  //Costo (elegido)
    $lsCampo[1][13] = 80;  //Costo (elegido)
    $lsCampo[1][14] = 80;  //Costo (elegido)
    $lsCampo[1][15] = 80;  //Costo (elegido)
    $lsCampo[1][16] = 80;  //Costo (elegido)
    
	$handle_1 = fopen("CorreccionMonetaria.xls", "w");
	$handle_2 = fopen("CorreccionMonetaria.htm", "w");
	
	fwrite($handle_2, "<LINK REL='stylesheet' TYPE='text/css' HREF='estilo.css'>");
	fwrite($handle_2, "<center><font size=3><b>Corrección monetaria ".trim($lsAno)."</b></font></center>");
	
	fwrite($handle_1, "<table>");
    
	$lsExcel = "<tr bgcolor='#e0e0e0' height=20>";
	for($x=0;$x<$msfields;$x++){
		$lsCelda = mssql_fetch_field($msresults,$x);
		$lsExcel = $lsExcel."<td nowrap align='center'>&nbsp;<b>".trim($lsCelda->name)."</b>&nbsp;</td>";
	}
    $lsExcel = $lsExcel."</tr>";
    
	fwrite($handle_1, $lsExcel);
	
	$liNum = 1;
	$lsAnterior_art = "";
	$lsAnterior_pla = "";
	
	fwrite($handle_2, "<br><table cellpadding=1 cellspacing=1>");
	
	while($row = mssql_fetch_array($msresults)){
		
		$liPorcentaje = intval(($liNum/$msrows)*100);
		echo "<script>MuestraDescripcion(".$liPorcentaje.")</script>";
		
		if($lsAnterior_art!=trim($row["Artículo"])||$lsAnterior_pla!=trim($row["Planta"])){
            fwrite($handle_2, "<tr><td colspan=17>&nbsp;</td></tr>");
            $lsSQL = "DOCUMENTOS..spCorreccionMonetaria @Tipo = 1, @Art = '".$lsAnterior_art."', @Pla = '".$lsAnterior_pla."'";
            $res = mssql_query($lsSQL);
            if($rw2 = mssql_fetch_array($res)){
                fwrite($handle_2, "<tr>
                <td colspan=9>&nbsp;</td>
                <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Saldo/Cant."]."&nbsp;</td>
                <td colspan=1>&nbsp;</td>
                <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Costo<br>&nbsp;Directo"]."&nbsp;</td>
                <td colspan=1>&nbsp;</td>
                <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Costo total<br>&nbsp;Elegido"]."&nbsp;</td>
                <td colspan=1>&nbsp;</td>
                <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Costo<br>&nbsp;Reposición"]."&nbsp;</td>
                <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Corrección<br>&nbsp;Monetaria"]."&nbsp;</td></tr>");
            }
            fwrite($handle_2, "<tr><td colspan=17>&nbsp;</td></tr>");
            fwrite($handle_2, $lsExcel);
        }
		
		fwrite($handle_1, "<tr>");
		
		$lsColor = "white";
		if(trim($row["Procedencia"])=="FIN"){
            $lsColor = "#fff33";
        }
        if(trim($row["Procedencia"])=="INI"){
            $lsColor = "#99ccff";
        }
        
		fwrite($handle_2, "<tr bgcolor = '".$lsColor."'>");
		
		for($x=0;$x<$msfields;$x++){
            
			$lsCelda = mssql_fetch_field($msresults,$x);
			fwrite($handle_1, "<td nowrap align='".$lsCampo[0][$x]."'>".trim($row[$lsCelda->name])."</td>");
			if($x>8){
                if($x>11&&$row["Procedencia"]=="INI"){
                    fwrite($handle_2, "<td nowrap align='".$lsCampo[0][$x]."' width='".$lsCampo[1][$x]."'>&nbsp;&nbsp;</td>");
                } else{
                    if($x==14){
                        fwrite($handle_2, "<td nowrap align='".$lsCampo[0][$x]."' width='".$lsCampo[1][$x]."'>&nbsp;".number_format(trim($row[$lsCelda->name]),4)."&nbsp;</td>");
                    } else{			
                        fwrite($handle_2, "<td nowrap align='".$lsCampo[0][$x]."' width='".$lsCampo[1][$x]."'>&nbsp;".number_format(trim($row[$lsCelda->name]),0)."&nbsp;</td>");
                    }
                }
            } else{
                fwrite($handle_2, "<td nowrap align='".$lsCampo[0][$x]."' width='".$lsCampo[1][$x]."'>&nbsp;".trim($row[$lsCelda->name])."&nbsp;</td>");
            }
			
		}
		
		$lsAnterior_art = trim($row["Artículo"]);
		$lsAnterior_pla = trim($row["Planta"]);
		
		fwrite($handle_1, "</tr>");
		fwrite($handle_2, "</tr>");
		$liNum++;
		
	}
	
    fwrite($handle_2, "<tr><td colspan=17>&nbsp;</td></tr>");
    $lsSQL = "DOCUMENTOS..spCorreccionMonetaria @Tipo = 1, @Art = '".$lsAnterior_art."', @Pla = '".$lsAnterior_pla."'";
    $res = mssql_query($lsSQL);
    if($rw2 = mssql_fetch_array($res)){
        fwrite($handle_2, "<tr>
        <td colspan=9>&nbsp;</td>
        <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Saldo/Cant."]."&nbsp;</td>
        <td colspan=1>&nbsp;</td>
        <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Costo<br>&nbsp;Directo"]."&nbsp;</td>
        <td colspan=1>&nbsp;</td>
        <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Costo total<br>&nbsp;Elegido"]."&nbsp;</td>
        <td colspan=1>&nbsp;</td>
        <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Costo<br>&nbsp;Reposición"]."&nbsp;</td>
        <td bgcolor='#ffff99' align='right'>&nbsp;".$rw2["Corrección<br>&nbsp;Monetaria"]."&nbsp;</td></tr>");
    }
	
	fwrite($handle_1, "</tr></table>");
	fwrite($handle_2, "</tr></table>");
	
    fclose($handle_1);
	fclose($handle_2);
    
?>
