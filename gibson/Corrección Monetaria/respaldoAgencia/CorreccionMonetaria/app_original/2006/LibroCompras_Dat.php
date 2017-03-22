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
    
    $lsPlanta = $HTTP_GET_VARS["PLA"];
    $lsMes    = $HTTP_GET_VARS["MES"];
    
	$lsSQL = "DOCUMENTOS..spLibroCompras @Planta = '".trim($lsPlanta)."', @Mes = '".trim($lsMes)."'";
	
	$msresults = mssql_query($lsSQL); 
	$msfields  = mssql_num_fields($msresults); 
	$msrows    = mssql_num_rows($msresults);
    
	$lsCampo = array();
	
	$lsCampo[0][0]  = "center";
	$lsCampo[0][1]  = "center";
	$lsCampo[0][2]  = "center";
	$lsCampo[0][3]  = "right";
	$lsCampo[0][4]  = "right";
	$lsCampo[0][5]  = "right";
	$lsCampo[0][6]  = "right";
	$lsCampo[0][7]  = "left";
	$lsCampo[0][8]  = "left";
	$lsCampo[0][9]  = "left";
	$lsCampo[0][10] = "right";
	$lsCampo[0][11] = "right";
	$lsCampo[0][12] = "right";
	$lsCampo[0][13] = "right";
	$lsCampo[0][14] = "right";
	$lsCampo[0][15] = "right";
	$lsCampo[0][16] = "right";
	$lsCampo[0][17] = "right";
	$lsCampo[0][18] = "right";
	$lsCampo[0][19] = "right";
	$lsCampo[0][20] = "right";
	$lsCampo[0][21] = "right";
	$lsCampo[0][22] = "right";
	$lsCampo[0][23] = "center";
	$lsCampo[0][24] = "right";
    
    $lsCampo[1][0]  = 80;  //Articulo
    $lsCampo[1][1]  = 80;  //Planta
    $lsCampo[1][2]  = 80;  //Fecha
    $lsCampo[1][3]  = 80;  //Nº Docto.
    $lsCampo[1][4]  = 80;  //PO
    $lsCampo[1][5]  = 80;  //Referencia
    $lsCampo[1][6]  = 80;  //Cod. Prov.
    $lsCampo[1][7]  = 200;  //Proveedor
    $lsCampo[1][8]  = 80;  //Procedencia
    $lsCampo[1][9]  = 80;  //U.M.
    $lsCampo[1][10] = 80;  //Cantidad
    $lsCampo[1][11] = 80;  //Costo
    $lsCampo[1][12] = 80;  //Tot. Factura
    $lsCampo[1][13] = 80;  //Desembolsos
    $lsCampo[1][14] = 80;  //Flete Interno
    $lsCampo[1][15] = 80;  //Gtos. Despacho
    $lsCampo[1][16] = 80;  //Otros Gastos
    $lsCampo[1][17] = 80;  //Honorarios
    $lsCampo[1][18] = 80;  //FOB
    $lsCampo[1][19] = 80;  //Flete
    $lsCampo[1][20] = 80;  //Seguro
    $lsCampo[1][21] = 80;  //Total
    $lsCampo[1][22] = 80;  //Embarque
    $lsCampo[1][23] = 80;  //Despacho
    $lsCampo[1][24] = 80;  //Tipo cambio
	
	$handle_1 = fopen("LibroCompras.xls", "w");
	$handle_2 = fopen("LibroCompras.htm", "w");
	
    define('FPDF_FONTPATH','../clientes/apps/pdf/font/');
    require('../clientes/apps/pdf/fpdf.php');
    
	class PDF extends FPDF{
	   
	   //Cabecera de página
		function Header(){
            
            global $lsTitulo;
            
            $this->SetFont('Arial','B',12);
            $this->Cell(300,5,"LIBRO DE COMPRAS 2006",0,0,'C',1);
            $this->Ln();
            $this->SetFont('Arial','B',10);
            $this->Cell(300,5,$lsTitulo,0,0,'C',1);
            $this->Ln();
            $this->Ln();
            
            $this->SetFont('Arial','B',5);
            $this->Cell(16,3,"Artículo","1",0,"C",0);
            $this->Cell(6,3,"Planta","1",0,"C",0);
            $this->Cell(12,3,"Fecha","1",0,"C",0);
            $this->Cell(13,3,"Documento","1",0,"C",0);
            $this->Cell(13,3,"PO","1",0,"C",0);
            $this->Cell(13,3,"Referencia","1",0,"C",0);
            $this->Cell(10,3,"Cod. Prov.","1",0,"C",0);
            $this->Cell(34,3,"Proveedor","1",0,"C",0);
            $this->Cell(19,3,"Procedencia","1",0,"C",0);
            $this->Cell(6,3,"U.M.","1",0,"C",0);
            $this->Cell(16,3,"Cantidad","1",0,"C",0);
            $this->Cell(11,3,"Costo","1",0,"C",0);
            $this->Cell(11,3,"Tot. Fact.","1",0,"C",0);
            $this->Cell(11,3,"Desembolsos","1",0,"C",0);
            $this->Cell(11,3,"Flete Int.","1",0,"C",0);
            $this->Cell(11,3,"Gtos. Desp.","1",0,"C",0);
            $this->Cell(11,3,"Otros Gtos.","1",0,"C",0);
            $this->Cell(11,3,"Honorarios","1",0,"C",0);
            $this->Cell(11,3,"FOB","1",0,"C",0);
            $this->Cell(11,3,"Flete","1",0,"C",0);
            $this->Cell(11,3,"Seguro","1",0,"C",0);
            $this->Cell(11,3,"Costo (SLI)","1",0,"C",0);
            $this->Cell(11,3,"Embarque","1",0,"C",0);
            $this->Cell(11,3,"Despacho","1",0,"C",0);
            $this->Cell(11,3,"Tipo cambio","1",0,"C",0);
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
	
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('','');    
    $pdf->AddPage();
	
	fwrite($handle_2, "<LINK REL='stylesheet' TYPE='text/css' HREF='estilo.css'>");
	fwrite($handle_2, "<center><font size=3><b>Libro de Compras 2006</b></font></center>");
	
	fwrite($handle_1, "<table>");
    
	$lsExcel = "<tr bgcolor='#e0e0e0' height=20>";
	for($x=0;$x<$msfields;$x++){
		$lsCelda = mssql_fetch_field($msresults,$x);
		$lsExcel = $lsExcel."<td nowrap align='center'>&nbsp;<b>".trim($lsCelda->name)."</b>&nbsp;</td>";
	}
    $lsExcel = $lsExcel."</tr>";
    
	fwrite($handle_1, $lsExcel);
	
	$liNum = 1;
	$lsAnterior = "";
	
	while($row = mssql_fetch_array($msresults)){
		
		$pdf->SetFont("Arial","",5);
        $pdf->Cell(16,3,trim($row["Artículo"]),"LR",0,"R",0);
        $pdf->Cell(6,3,trim($row["Planta"]),"LR",0,"R",0);
        $pdf->Cell(12,3,trim($row["Fecha"]),"LR",0,"C",0);
        $pdf->Cell(13,3,trim($row["Documento"]),"LR",0,"R",0);
        $pdf->Cell(13,3,trim($row["PO"]),"LR",0,"R",0);
        $pdf->Cell(13,3,trim($row["Referencia"]),"LR",0,"R",0);
        $pdf->Cell(10,3,trim($row["Cod. Prov."]),"LR",0,"R",0);
        $pdf->Cell(34,3,trim($row["Proveedor"]),"LR",0,"L",0);
        $pdf->Cell(19,3,trim($row["Procedencia"]),"LR",0,"L",0);
        $pdf->Cell(6,3,trim($row["U.M."]),"LR",0,"C",0);
        $pdf->Cell(16,3,trim($row["Cantidad"]),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Costo"]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Tot. Fact."]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Desembolsos"]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Flete Int."]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Gtos. Desp."]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Otros Gtos."]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Honorarios"]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["FOB"]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Flete"]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Seguro"]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Costo (SLI)"]),0),"LR",0,"R",0);
        $pdf->Cell(11,3,trim($row["Embarque"]),"LR",0,"R",0);
        $pdf->Cell(11,3,trim($row["Despacho"]),"LR",0,"R",0);
        $pdf->Cell(11,3,number_format(trim($row["Tipo cambio"]),2),"LR",0,"R",0);
        $pdf->Ln();
		
		$liPorcentaje = intval(($liNum/$msrows)*100);
		echo "<script>MuestraDescripcion(".$liPorcentaje.")</script>";
		
		if($lsAnterior!=trim($row["Artículo"])){
            if(trim($lsAnterior)!=""){
                fwrite($handle_2, "</table>");
            }
            fwrite($handle_2, "<br><table cellpadding=1 cellspacing=1>");
            fwrite($handle_2, $lsExcel);
        }
		
		fwrite($handle_1, "<tr>");
		fwrite($handle_2, "<tr>");
		
		for($x=0;$x<$msfields;$x++){
            
			$lsCelda = mssql_fetch_field($msresults,$x);
			switch(trim($row["Tipo Mov."])){
                case "999":
                    $lsColor = "#fff33";
                    break;
                case "000":
                    $lsColor = "#99ccff";
                    break;
                default:
                    $lsColor = "white";
                    break;
            }
			
			fwrite($handle_1, "<td bgcolor = '".$lsColor."' nowrap align='".$lsCampo[0][$x]."'>".trim($row[$lsCelda->name])."</td>");
			
			$lsValor = trim($row[$lsCelda->name]);
            if($x>=10&&$x<=21){
                $lsValor = number_format(trim($row[$lsCelda->name]),0,",",".");
            }
			fwrite($handle_2, "<td bgcolor = '".$lsColor."' nowrap align='".$lsCampo[0][$x]."' width='".$lsCampo[1][$x]."'>&nbsp;".$lsValor."&nbsp;</td>");
			
		}
		$lsAnterior= trim($row["Artículo"]);
		
		fwrite($handle_1, "</tr>");
		fwrite($handle_2, "</tr>");
		$liNum++;
		
	}
	
	fwrite($handle_1, "</tr></table>");
	fwrite($handle_2, "</tr></table>");
	
    fclose($handle_1);
	fclose($handle_2);
	
	$pdf->Output("LibroCompras.pdf");
    
?>
