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
    
    $lsPlanta   = $HTTP_GET_VARS["PLA"];
    $lsArticulo = $HTTP_GET_VARS["ART"];
    
    $lsTitulo = "Planta ".$lsPlanta.", ".rgMes(substr($lsMes,4,2))." de ".substr($lsMes,0,4)." Articulo ".$lsArticulo;
    
	$lsSQL = "
    	SELECT	articulo			[Artículo],
    			planta				[Planta],
    			bodega				[Bodega],
    			cantidad			[Cantidad],
    			saldo				[Saldo],
    			unidad				[U.M.],
    			costo				[Costo (SAP)],
    			ppp					[PPP],
    			sli_total			[Costo (SLI)],
    			valor				[Valor (SAP)],
    			mov_tipo                         [Tipo Mov.],
    			mov_desc                         [Movimiento],
    			docto_num			             [Nº Docto.],
    			CONVERT(CHAR(10),docto_fec,103)  [Fecha],
    			referencia                       [Referencia],
    			ISNULL(po,'')                    [PO],
    			cod_proveedor                    [Cod. Prov.],
    			proveedor                        [Proveedor]
        FROM	DOCUMENTOS..tmp_libroexistencias
        WHERE   planta   = '".$lsPlanta."' AND
                articulo = '".$lsArticulo."'
        ORDER	BY
        		planta,
        		articulo,
        		docto_fec,
        		id";
	
	$msresults = mssql_query($lsSQL); 
	$msfields  = mssql_num_fields($msresults);
	$msrows    = mssql_num_rows($msresults);
    
	$lsCampo = array();
	
	$lsCampo[0][0]  = "right";
	$lsCampo[0][1]  = "left";
	$lsCampo[0][2]  = "left";
	$lsCampo[0][3]  = "right";
	$lsCampo[0][4]  = "right";
	$lsCampo[0][5]  = "left";
	$lsCampo[0][6]  = "right";
	$lsCampo[0][7]  = "right";
	$lsCampo[0][8]  = "right";
	$lsCampo[0][9]  = "right";
	$lsCampo[0][10] = "right";
	$lsCampo[0][11] = "left";
	$lsCampo[0][12] = "right";
	$lsCampo[0][13] = "center";
	$lsCampo[0][14] = "right";
	$lsCampo[0][15] = "right";
	$lsCampo[0][16] = "right";
	$lsCampo[0][17] = "left";
    
	$lsCampo[1][0]  = 100; // Articulo
	$lsCampo[1][1]  = 50;  // Planta
	$lsCampo[1][2]  = 50;  // Bodega
	$lsCampo[1][3]  = 70;  // Cantidad
	$lsCampo[1][4]  = 70;  // Saldo
	$lsCampo[1][5]  = 40;  // U.M.
	$lsCampo[1][6]  = 70;  // Valor
	$lsCampo[1][7]  = 50;  // Moneda
	$lsCampo[1][8]  = 80;  // Costo
	$lsCampo[1][9]  = 80;  // SLI
	$lsCampo[1][10] = 80;  // Tipo Mov.
	$lsCampo[1][11] = 100; // Movimiento
	$lsCampo[1][12] = 30;  // REG
	$lsCampo[1][13] = 60;  // Nº Docto.
	$lsCampo[1][14] = 70;  // Fec. Docto.
	$lsCampo[1][15] = 100; // Referencia
	$lsCampo[1][16] = 200; // Proveedor
	$lsCampo[1][17] = 80;  // PO Num.
	
	echo "<LINK REL='stylesheet' TYPE='text/css' HREF='estilo.css'>";
	echo "<table cellpadding=1 cellspacing=1 align='center'>
	<tr><td align='center'><font size=3><b>Libro de Existencias</b></font></td></tr>
	<tr><td align='center'><font size=2><b>".$lsTitulo."</b></font></td></tr>
	</table><br>";
	
	echo "<table>";
	echo "<table cellpadding=1 cellspacing=1>";
    
	$lsCabecera = "<tr bgcolor='#e0e0e0' height=20>";
	for($x=0;$x<$msfields;$x++){
		$lsCelda = mssql_fetch_field($msresults,$x);
		$lsCabecera = $lsCabecera."<td nowrap align='center'>&nbsp;<b>".trim($lsCelda->name)."</b>&nbsp;</td>";
	}
    $lsCabecera = "<tr>".$lsCabecera."</tr>";
    
	$liNum = 1;
	
	while($row = mssql_fetch_array($msresults)){
        
		switch(trim($row["Tipo Mov."])){
            case "999":
                $lsColor = "#fff33";
                break;
            case "000":
                echo $lsCabecera;
                $lsColor = "#99ccff";
                break;
            default:
                $lsColor = "white";
                break;
        }
		echo "<tr bgcolor = '".$lsColor."'>";
		for($x=0;$x<$msfields;$x++){
            
			$lsCelda = mssql_fetch_field($msresults,$x);
			$ls_CAM_Valor = trim($row[$lsCelda->name]);
            switch($x){
                case 3:
                case 4:
                case 6:
                case 7:
                case 8:
                case 9:
                    $ls_CAM_Valor = number_format($row[$lsCelda->name],0);
                    break;
            }
            echo "<td nowrap align='".$lsCampo[0][$x]."'>&nbsp;".$ls_CAM_Valor."&nbsp;</td>";
			
		}
		
		echo "</tr>";
        if(trim($row["Tipo Mov."])=="999"){
            echo "<tr><td colspan=18 nowrap>&nbsp;</td></tr>";
            $laMes = split("/",$row["Fecha"]);
            $lsMes = $laMes[2].$laMes[1];
            $lsSQL = "DOCUMENTOS..spLibroExistencias_002 @planta = '".$lsPlanta."', @mes = '".$lsMes."', @articulo = '".trim($row["Artículo"])."'";
            $msresults_2 = mssql_query($lsSQL); 
            while($row_2 = mssql_fetch_array($msresults_2)){
                echo "
                    <tr>
                        <td colspan=4 nowrap>&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Cantidad"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap>&nbsp;".trim($row_2["U.M."])."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Costo (SAP)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["PPP"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Costo (SLI)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Valor (SAP)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".trim($row_2["Tipo Mov."])."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap>&nbsp;".trim($row_2["Movimiento"])."&nbsp;</td>
                    </tr>";
            }
            echo "<tr><td colspan=18 nowrap>&nbsp;</td></tr>";
        }
		$liNum++;
		
	}
	
	echo "</tr></table>";
	
	function rgMes($iMes){
	   
	   switch($iMes){
	       case "01":
	           return "Enero";
	           break;
	       case "02":
	           return "Febrero";
	           break;
	       case "03":
	           return "Marzo";
	           break;
	       case "04":
	           return "Abril";
	           break;
	       case "05":
	           return "Mayo";
	           break;
	       case "06":
	           return "Junio";
	           break;
	       case "07":
	           return "Julio";
	           break;
	       case "08":
	           return "Agosto";
	           break;
	       case "09":
	           return "Septiembre";
	           break;
	       case "10":
	           return "Octubre";
	           break;
	       case "11":
	           return "Noviembre";
	           break;
	       case "12":
	           return "Diciembre";
	           break;
       }
	   
    }
    
?>
