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
    
	$handle_1 = fopen("LibroExistencias.xls", "w");
	$handle_2 = fopen("LibroExistencias.htm", "w");
	
    define('FPDF_FONTPATH','../clientes/apps/pdf/font/');
    require('../clientes/apps/pdf/fpdf.php');
    
    $lsPlanta = $HTTP_GET_VARS["PLA"];
    $lsMes    = $HTTP_GET_VARS["MES"];
    
    $lsPlanta = $HTTP_GET_VARS["PLA"];
    $lsMes    = $HTTP_GET_VARS["MES"];
    
    $lsTitulo = "Planta ".$lsPlanta.", ".rgMes(substr($lsMes,4,2))." de ".substr($lsMes,0,4);
    
	class PDF extends FPDF{
	   
	   //Cabecera de página
		function Header(){
            
            global $lsTitulo;
            
            $this->SetFont('Arial','B',12);
            $this->Cell(300,5,"LIBRO DE EXISTENCIAS 2006",0,0,'C',1);
            $this->Ln();
            $this->SetFont('Arial','B',10);
            $this->Cell(300,5,$lsTitulo,0,0,'C',1);
            $this->Ln();
            $this->Ln();            

		}
		//Pie de página
		function Footer(){
			//Posición: a 1,5 cm del final
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			//Número de página
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
		}
		
	}
	
    $pdf = new PDF();
	$pdf->FPDF('P','mm',array(330,215));
	$pdf->AliasNbPages();
	    
	$lsSQL = "
    	SELECT	articulo			[Artículo],
    			planta				[Planta],
    			bodega				[Bodega],
    			cantidad			[Cantidad],
    			saldo				[Saldo],
    			unidad				[U.M.],
    			costo				[Costo (SAP)],
    			sli_total			[Costo (SLI)],
    			ppp					[Costo (PPP)],
    			valor				[Valor (SAP)],
    			sli_total*cantidad	[Valor (SLI)],
    			ppp*cantidad	    [Valor (PPP)],
    			mov_tipo			[Tipo Mov.],
    			mov_desc			[Movimiento],
    			docto_num			[Nº Docto.],
    			CONVERT(CHAR(10),docto_fec,103)  [Fecha],
    			referencia                       [Referencia],
    			ISNULL(po,'')                    [PO],
    			cod_proveedor                    [Cod. Prov.],
    			proveedor                        [Proveedor]
        FROM	DOCUMENTOS..tmp_libroexistencias
        WHERE   CONVERT(CHAR(6),docto_fec,112) = '".$lsMes."' AND
                planta = '".$lsPlanta."'
        ORDER	BY
        		planta,
        		articulo,
        		docto_fec,
        		mov_desc,
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
	$lsCampo[0][11] = "right";
	$lsCampo[0][12] = "right";
	$lsCampo[0][13] = "left";
	$lsCampo[0][14] = "right";
	$lsCampo[0][15] = "center";
	$lsCampo[0][16] = "right";
	$lsCampo[0][17] = "right";
	$lsCampo[0][18] = "right";
	$lsCampo[0][19] = "left";
    
	$lsCampo[1][0]  = 100; // Articulo
	$lsCampo[1][1]  = 50;  // Planta
	$lsCampo[1][2]  = 50;  // Bodega
	$lsCampo[1][3]  = 70;  // Cantidad
	$lsCampo[1][4]  = 70;  // Saldo
	$lsCampo[1][5]  = 40;  // U.M.
	$lsCampo[1][6]  = 70;  // Costo (SAP)
	$lsCampo[1][7]  = 70;  // Costo (SLI)
	$lsCampo[1][8]  = 70;  // Costo (PPP)
	$lsCampo[1][9]  = 70;  // Valor (SAP)
	$lsCampo[1][10] = 80;  // Valor (SLI)
	$lsCampo[1][11] = 80;  // Valor (PPP)
	$lsCampo[1][12] = 80;  // Tipo Mov.
	$lsCampo[1][13] = 100; // Movimiento
	$lsCampo[1][14] = 30;  // REG
	$lsCampo[1][15] = 60;  // Nº Docto.
	$lsCampo[1][16] = 70;  // Fec. Docto.
	$lsCampo[1][17] = 100; // Referencia
	$lsCampo[1][18] = 200; // Proveedor
	$lsCampo[1][19] = 80;  // PO Num.
	
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('','');    
    $pdf->AddPage();
    
    $pdf->SetFont('Arial','B',6);
    $pdf->Cell(5,3,"",0,0,'C',1);
    $pdf->Cell(17,3,"Artículo","BT",0,"C",0);
    $pdf->Cell(10,3,"Planta","BT",0,"C",0);
    $pdf->Cell(10,3,"Bodega","BT",0,"C",0);
    $pdf->Cell(10,3,"Cant.","BT",0,"C",0);
    $pdf->Cell(10,3,"Saldo","BT",0,"C",0);
    $pdf->Cell(10,3,"U.M.","BT",0,"C",0);
    $pdf->Cell(15,3,"Costo (SAP)","BT",0,"C",0);
    $pdf->Cell(15,3,"Costo (SLI)","BT",0,"C",0);
    $pdf->Cell(15,3,"Costo (PPP)","BT",0,"C",0);
    $pdf->Cell(15,3,"Valor (SAP)","BT",0,"C",0);
    $pdf->Cell(15,3,"Valor (SLI)","BT",0,"C",0);
    $pdf->Cell(15,3,"Valor (PPP)","BT",0,"C",0);
    $pdf->Cell(12,3,"Tipo Mov.","BT",0,"C",0);
    $pdf->Cell(23,3,"Movimiento","BT",0,"C",0);
    $pdf->Cell(15,3,"Nº Docto.","BT",0,"C",0);
    $pdf->Cell(15,3,"Fecha","BT",0,"C",0);
    $pdf->Cell(15,3,"Referencia","BT",0,"C",0);
    $pdf->Cell(15,3,"PO","BT",0,"C",0);
    $pdf->Cell(15,3,"Cod. Prov.","BT",0,"C",0);
    $pdf->Cell(32,3,"Proveedor","BT",0,"C",0);
    $pdf->Ln();
    
	$lsFila = "
        <LINK REL='stylesheet' TYPE='text/css' HREF='estilo.css'>
    	<table cellpadding=0 cellspacing=0 align='center'>
    	<tr><td align='center'><font size=3><b>Libro de Existencias</b></font></td></tr>
    	<tr><td align='center'><font size=2><b>".$lsTitulo."</b></font></td></tr>
    	</table><br>
    	<table>
    	<table cellpadding=0 cellspacing=0>";
    	
	$lsFila_2 = "
    	<table cellpadding=0 cellspacing=0 align='center'>
    	<tr><td align='center'><font size=3><b>Libro de Existencias</b></font></td></tr>
    	<tr><td align='center'><font size=2><b>".$lsTitulo."</b></font></td></tr>
    	</table><br>
    	<table>
    	<table cellpadding=0 cellspacing=0>";
	
    fwrite($handle_1, $lsFila_2);
    fwrite($handle_2, $lsFila);
    
	$lsCabecera = "<tr bgcolor='#e0e0e0' height=20>";
	for($x=0;$x<$msfields;$x++){
		$lsCelda = mssql_fetch_field($msresults,$x);
		$lsCabecera = $lsCabecera."<td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>".trim($lsCelda->name)."</b>&nbsp;</td>";
	}
    $lsCabecera = "<tr>".$lsCabecera."</tr>";
    
	$liNum = 1;
	
	while($row = mssql_fetch_array($msresults)){
	   
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(5,5,"",0,0,'C',1);
        
        $pdf->Cell(17,3,trim($row["Artículo"]),0,0,"R",0);
        $pdf->Cell(10,3,trim($row["Planta"]),0,0,"C",0);
        $pdf->Cell(10,3,trim($row["Bodega"]),0,0,"C",0);
        $pdf->Cell(10,3,trim($row["Cantidad"]),0,0,"R",0);
        $pdf->Cell(10,3,trim($row["Saldo"]),0,0,"R",0);
        $pdf->Cell(10,3,trim($row["U.M."]),0,0,"C",0);
        $pdf->Cell(15,3,trim($row["Costo (SAP)"]),0,0,"R",0);
        $pdf->Cell(15,3,trim($row["Costo (SLI)"]),0,0,"R",0);
        $pdf->Cell(15,3,trim($row["Costo (PPP)"]),0,0,"R",0);
        $pdf->Cell(15,3,trim($row["Valor (SAP)"]),0,0,"R",0);
        $pdf->Cell(15,3,trim($row["Valor (SLI)"]),0,0,"R",0);
        $pdf->Cell(15,3,trim($row["Valor (PPP)"]),0,0,"R",0);
        $pdf->Cell(12,3,trim($row["Tipo Mov."]),0,0,"R",0);
        $pdf->Cell(23,3,trim($row["Movimiento"]),0,0,"L",0);
        $pdf->Cell(15,3,trim($row["Nº Docto."]),0,0,"R",0);
        $pdf->Cell(15,3,trim($row["Fecha"]),0,0,"C",0);
        $pdf->Cell(15,3,trim($row["Referencia"]),0,0,"R",0);
        $pdf->Cell(15,3,trim($row["PO"]),0,0,"R",0);
        $pdf->Cell(15,3,trim($row["Cod. Prov."]),0,0,"R",0);
        $pdf->Cell(32,3,trim($row["Proveedor"]),0,0,"L",0);
        
		switch(trim($row["Tipo Mov."])){
            case "ZZZ":
                $lsColor = "#fff33";
                break;
            case "000":
                fwrite($handle_1, $lsCabecera);
                fwrite($handle_2, $lsCabecera);
                $lsColor = "#99ccff";
                break;
            default:
                $lsColor = "white";
                break;
        }
        
		$lsFila = "<tr bgcolor = '".$lsColor."'>";
        fwrite($handle_1, $lsFila);
        fwrite($handle_2, $lsFila);
        
        $lsFila = "";
        $lsFil2 = "";
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
                case 10:
                case 11:
                    $ls_CAM_Valor = number_format($row[$lsCelda->name],0);
                    break;
            }
            $lsFila = $lsFila."<td nowrap align='".$lsCampo[0][$x]."'>&nbsp;".$ls_CAM_Valor."&nbsp;</td>";
            $lsFil2 = $lsFil2."<td nowrap align='".$lsCampo[0][$x]."'>".$ls_CAM_Valor."</td>";
			
		}
        fwrite($handle_1, $lsFil2);
        fwrite($handle_2, $lsFila);
        $pdf->Ln();
		
		$lsFila = "</tr>";
		$lsFil2 = "</tr>";
        if(trim($row["Tipo Mov."])=="ZZZ"){
            $lsFila = $lsFila."<tr><td colspan=18 nowrap>&nbsp;</td></tr>";
            $laMes = split("/",$row["Fecha"]);
            $lsMes = $laMes[2].$laMes[1];
            $lsSQL = "DOCUMENTOS..spLibroExistencias_002 @planta = '".$lsPlanta."', @mes = '".$lsMes."', @articulo = '".trim($row["Artículo"])."'";
            $msresults_2 = mssql_query($lsSQL); 
            $pdf->Ln();
            while($row_2 = mssql_fetch_array($msresults_2)){
                
                $lsFila = $lsFila."
                    <tr>
                        <td colspan=4 nowrap>&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Cantidad"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap>&nbsp;".trim($row_2["U.M."])."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Costo (SAP)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Costo (SLI)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Costo (PPP)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Valor (SAP)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Valor (SLI)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Valor (PPP)"]),0)."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".trim($row_2["Tipo Mov."])."&nbsp;</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap>&nbsp;".trim($row_2["Movimiento"])."&nbsp;</td>
                    </tr>";
                    
                $lsFil2 = $lsFil2."
                    <tr>
                        <td colspan=4 nowrap></td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Cantidad"]),0)."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap>".trim($row_2["U.M."])."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Costo (SAP)"]),0)."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Costo (SLI)"]),0)."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Costo (PPP)"]),0)."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Valor (SAP)"]),0)."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Valor (SLI)"]),0)."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Valor (PPP)"]),0)."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".trim($row_2["Tipo Mov."])."</td>
                        <td bgcolor='#ffff99' colspan=1 nowrap>".trim($row_2["Movimiento"])."</td>
                    </tr>";

                $pdf->Cell(52,3,"",0,0,"R",0);
                $pdf->Cell(10,3,number_format(trim($row_2["Cantidad"]),0),0,0,"R",0);
                $pdf->Cell(10,3,trim($row_2["U.M."]),0,0,"C",0);
                $pdf->Cell(15,3,number_format(trim($row_2["Costo (SAP)"]),0),0,0,"R",0);
                $pdf->Cell(15,3,number_format(trim($row_2["Costo (SLI)"]),0),0,0,"R",0);
                $pdf->Cell(15,3,number_format(trim($row_2["Costo (PPP)"]),0),0,0,"R",0);
                $pdf->Cell(15,3,number_format(trim($row_2["Valor (SAP)"]),0),0,0,"R",0);
                $pdf->Cell(15,3,number_format(trim($row_2["Valor (SLI)"]),0),0,0,"R",0);
                $pdf->Cell(15,3,number_format(trim($row_2["Valor (PPP)"]),0),0,0,"R",0);
                $pdf->Cell(12,3,trim($row_2["Tipo Mov."]),0,0,"R",0);
                $pdf->Cell(23,3,trim($row_2["Movimiento"]),0,0,"L",0);
                $pdf->Ln();
                    
                    
            }
            $pdf->Ln();
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(5,3,"",0,0,'C',1);
            $pdf->Cell(17,3,"Artículo","BT",0,"C",0);
            $pdf->Cell(10,3,"Planta","BT",0,"C",0);
            $pdf->Cell(10,3,"Bodega","BT",0,"C",0);
            $pdf->Cell(10,3,"Cant.","BT",0,"C",0);
            $pdf->Cell(10,3,"Saldo","BT",0,"C",0);
            $pdf->Cell(10,3,"U.M.","BT",0,"C",0);
            $pdf->Cell(15,3,"Costo (SAP)","BT",0,"C",0);
            $pdf->Cell(15,3,"Costo (SLI)","BT",0,"C",0);
            $pdf->Cell(15,3,"Costo (PPP)","BT",0,"C",0);
            $pdf->Cell(15,3,"Valor (SAP)","BT",0,"C",0);
            $pdf->Cell(15,3,"Valor (SLI)","BT",0,"C",0);
            $pdf->Cell(15,3,"Valor (PPP)","BT",0,"C",0);
            $pdf->Cell(12,3,"Tipo Mov.","BT",0,"C",0);
            $pdf->Cell(23,3,"Movimiento","BT",0,"C",0);
            $pdf->Cell(15,3,"Nº Docto.","BT",0,"C",0);
            $pdf->Cell(15,3,"Fecha","BT",0,"C",0);
            $pdf->Cell(15,3,"Referencia","BT",0,"C",0);
            $pdf->Cell(15,3,"PO","BT",0,"C",0);
            $pdf->Cell(15,3,"Cod. Prov.","BT",0,"C",0);
            $pdf->Cell(32,3,"Proveedor","BT",0,"C",0);
            $pdf->Ln();
            $lsFila = $lsFila."<tr><td colspan=18>&nbsp;</td></tr>";
        }
		$liNum++;
		
        fwrite($handle_1, $lsFil2);
        fwrite($handle_2, $lsFila);
		
	}
	
    $lsFila = "
    <tr><td colspan=18>&nbsp;</td></tr>
    <tr><td colspan=18 align='center'>&nbsp;<b>Resumen movimientos</b>&nbsp;</td></tr>
    <tr><td colspan=18>&nbsp;</td></tr>
    <tr bgcolor='#e0e0e0' height=20>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Saldo</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>U.M.</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Costo (SAP)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Costo (SLI)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Costo (PPP)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Valor (SAP)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Valor (SLI)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Valor (PPP)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Tipo Mov.</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Movimiento</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        </tr>";
        
    $lsFil2 = "
    <tr><td colspan=18>&nbsp;</td></tr>
    <tr><td colspan=18 align='center'>&nbsp;<b>Resumen movimientos</b>&nbsp;</td></tr>
    <tr><td colspan=18>&nbsp;</td></tr>
    <tr bgcolor='#e0e0e0' height=20>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Saldo</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>U.M.</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Costo (SAP)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Costo (SLI)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Costo (PPP)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Valor (SAP)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Valor (SLI)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Valor (PPP)</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Tipo Mov.</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;<b>Movimiento</b>&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        <td nowrap align='center' style='border-bottom:1px outset;border-top:1px inset'>&nbsp;&nbsp;</td>
        </tr>";
    
    $lsSQL = "DOCUMENTOS..spLibroExistencias_002 @tipo = 1, @planta = '".$lsPlanta."', @mes = '".$lsMes."'";
    $msresults_2 = mssql_query($lsSQL); 
    while($row_2 = mssql_fetch_array($msresults_2)){
        
        $lsFila = $lsFila."
            <tr>
                <td colspan=4 nowrap>&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Cantidad"]),0)."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap>&nbsp;".trim($row_2["U.M."])."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Costo (SAP)"]),0)."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Costo (SLI)"]),0)."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Costo (PPP)"]),0)."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Valor (SAP)"]),0)."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Valor (SLI)"]),0)."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".number_format(trim($row_2["Valor (PPP)"]),0)."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>&nbsp;".trim($row_2["Tipo Mov."])."&nbsp;</td>
                <td bgcolor='#ffff99' colspan=1 nowrap>&nbsp;".trim($row_2["Movimiento"])."&nbsp;</td>
            </tr>";
            
        $lsFil2 = $lsFil2."
            <tr>
                <td colspan=4 nowrap></td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Cantidad"]),0)."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap>".trim($row_2["U.M."])."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Costo (SAP)"]),0)."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Costo (SLI)"]),0)."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Costo (PPP)"]),0)."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Valor (SAP)"]),0)."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Valor (SLI)"]),0)."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".number_format(trim($row_2["Valor (PPP)"]),0)."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap align='right'>".trim($row_2["Tipo Mov."])."</td>
                <td bgcolor='#ffff99' colspan=1 nowrap>".trim($row_2["Movimiento"])."</td>
            </tr>";
            
        $pdf->Cell(52,3,"",0,0,"R",0);
        $pdf->Cell(10,3,number_format(trim($row_2["Cantidad"]),0),0,0,"R",0);
        $pdf->Cell(10,3,trim($row_2["U.M."]),0,0,"C",0);
        $pdf->Cell(15,3,number_format(trim($row_2["Costo (SAP)"]),0),0,0,"R",0);
        $pdf->Cell(15,3,number_format(trim($row_2["Costo (SLI)"]),0),0,0,"R",0);
        $pdf->Cell(15,3,number_format(trim($row_2["Costo (PPP)"]),0),0,0,"R",0);
        $pdf->Cell(15,3,number_format(trim($row_2["Valor (SAP)"]),0),0,0,"R",0);
        $pdf->Cell(15,3,number_format(trim($row_2["Valor (SLI)"]),0),0,0,"R",0);
        $pdf->Cell(15,3,number_format(trim($row_2["Valor (PPP)"]),0),0,0,"R",0);
        $pdf->Cell(12,3,trim($row_2["Tipo Mov."]),0,0,"R",0);
        $pdf->Cell(23,3,trim($row_2["Movimiento"]),0,0,"L",0);
        $pdf->Ln();
        
    }
    fwrite($handle_1, $lsFil2);
    fwrite($handle_2, $lsFila);
	
	$lsFila = "</table>";
    fwrite($handle_1, $lsFila);
    fwrite($handle_2, $lsFila);
    
    fclose($handle_1);
    fclose($handle_2);
    
    $pdf->Output("LibroExistencias.pdf");
	
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
