<?php
    define('FPDF_FONTPATH','../clientes/apps/pdf/font/');
    require('../clientes/apps/pdf/fpdf.php');
	class PDF extends FPDF
	{
	//Cabecera de página
		function Header()
		{
			//Logo
			//$this->Image('logo_pb.png',10,8,33);
			//Arial bold 15
			//$this->SetFont('Arial','B',15);
			//Movernos a la derecha
			//$this->Cell(80);
			//Título
			//$this->Cell(30,10,'Title',1,0,'C');
			//Salto de línea
			//$this->Ln(20);
		}
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			//Número de página
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
    $pdf=new PDF();
	$pdf->FPDF('P','mm',array(330,215));
	$pdf->AliasNbPages();
    $lsPlanta = $HTTP_GET_VARS["PLA"];
    $lsMes    = $HTTP_GET_VARS["MES"];
	$suma	  = 0;
    $lar = 3;
	//para hacer la suma
	$verf = 0;
	$reg =array();
	$cant =array();
	$des = array();
	$cont = 0;
	// fin de variable para hacer suma 
	if (($conectID = mssql_connect("jupiter","sis_comex","comusr"))){ 
		if (mssql_select_db("documentos"))
		{
            $lsSQL  = "spLibroExistencias @mes = ".$lsMes.", @planta = '".$lsPlanta."'";
            $result = mssql_query($lsSQL);
            $msfields  = mssql_num_fields($result); 
			$num = mssql_num_rows($result); //numero de fila
            $pdf->AddPage();
			$pdf->SetFont('Arial','',18);
			$pdf->Cell(330,5,"Libro de Existencias ",0,0,'C',0);
			$pdf->ln(15);
			// Tamaño de Letra
            $pdf->SetFont('Arial','',6);
			//Color de Fondo de los nombres de Campo
			$pdf->SetFillColor(240,240,240);
			$pdf->SetFont('','B');
			$pdf->SetDrawColor(255,255,255);
			$lsCelda = mssql_fetch_field($result,0);
			$pdf->Cell(20,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,1);
			$pdf->Cell(10,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,2);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,3);
			$pdf->Cell(12,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,4);
			$pdf->Cell(6,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,5);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,6);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,7);
			$pdf->Cell(10,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,8);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,9);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,10);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,11);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,12);
			$pdf->Cell(25,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,13);
			$pdf->Cell(8,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,14);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,15);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,16);
			$pdf->Cell(25,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,17);
			$pdf->Cell(45,$lar,trim($lsCelda->name),1,0,'C',1);
			$lsCelda = mssql_fetch_field($result,18);
			$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
			$pdf->ln($lar);
			// Recorre fila por fila para ser Mostrado
            while($row_cab = mssql_fetch_array($result))
			{
				$verf = 0;
				$pdf->SetFont('','');
				if(trim($row_cab["Movimiento"])=="SALDO INICIAL")
				{
					//Color Fondo para saldo incial
					$pdf->SetFillColor(153,204,238);
				}
				elseif(trim($row_cab["Movimiento"])=="SALDO FINAL")
				{
					$pdf->SetFillColor(238,243,3);
				}
				else
				{
					$pdf->SetFillColor(255,255,255);
				}
				//Mostrar registro con su respectiva alineación y el largo de la celda
				//Cell(largo celda,alto celda,texto,borde,0,C(center)R(derecha)L(left),1(con color 		
				//fondo)0(sin color fondo);
                $pdf->Cell(20,$lar,trim($row_cab["Artículo"]),1,0,'R',1);
                $pdf->Cell(10,$lar,trim($row_cab["Bodega"]),1,0,'C',1);
                $pdf->Cell(15,$lar,number_format($row_cab["Cantidad"],0,',','.'),1,0,'R',1);
                $pdf->Cell(12,$lar,number_format($row_cab["Saldo"],0,',','.'),1,0,'R',1);
                $pdf->Cell(6,$lar,trim($row_cab["U.M."]),1,0,'C',1);
                $pdf->Cell(15,$lar,number_format($row_cab["Valor (SAP)"],0,',','.'),1,0,'R',1);
                $pdf->Cell(15,$lar,number_format($row_cab["Valor (PPP)"],0,',','.'),1,0,'R',1);
                $pdf->Cell(10,$lar,trim($row_cab["Moneda)"]),1,0,'C',1);
                $pdf->Cell(15,$lar,number_format($row_cab["Costo (SAP)"],0,',','.'),1,0,'R',1);
                $pdf->Cell(15,$lar,number_format($row_cab["Costo (SLI)"],0,',','.'),1,0,'R',1);
                $pdf->Cell(15,$lar,number_format($row_cab["PPP"],0,',','.'),1,0,'R',1);
                $pdf->Cell(15,$lar,trim($row_cab["Tipo Mov."]),1,0,'R',1);
                $pdf->Cell(25,$lar,trim($row_cab["Movimiento"]),1,0,'L',1);
                $pdf->Cell(8,$lar,trim($row_cab["REG"]),1,0,'R',1);
                $pdf->Cell(15,$lar,trim($row_cab["Nº Docto."]),1,0,'R',1);
                $pdf->Cell(15,$lar,trim($row_cab["Fec. Docto."]),1,0,'C',1);
                $pdf->Cell(25,$lar,trim($row_cab["Referencia"]),1,0,'L',1);
                $pdf->Cell(45,$lar,trim($row_cab["Proveedor"]),1,0,'L',1);
                $pdf->Cell(15,$lar,trim($row_cab["PO Num."]),1,0,'R',1);
                $pdf->ln($lar);
				//Sumar la cantidad de Articulo
				for ($x = 0; $x < $cont; $x++)
				{
					if (trim($row_cab["Tipo Mov."])==$reg[$x])
					{
						if ($reg[$x]=="999" or $reg[$x]=="000")
						{
							$verf = 1;
							$cant[$x] = $cant[$x] + trim($row_cab["Saldo"]);
						}
						else
						{
							$verf = 1;
							$cant[$x] = $cant[$x] + trim($row_cab["Cantidad"]);
						}
					}
				}
				if ($verf == 0)
				{
					$reg[$cont] = trim($row_cab["Tipo Mov."]);
					if (trim($row_cab["Tipo Mov."])=="999" or trim($row_cab["Tipo Mov."])=="000")
					{
						$cant[$cont] = trim($row_cab["Saldo"]);
						
						
					}
					else
					{
						$cant[$cont] = trim($row_cab["Cantidad"]);
					}
					$des[$cont] = trim($row_cab["Movimiento"]);
					$cont++;
				}
				//Fin de suma de cantidad de articulo
				if(trim($row_cab["Movimiento"])=="SALDO FINAL")
				{
					for ($c = 0; $c < $cont; $c++)
					{
						//Muestra el Tipo de Movimiento
						$pdf->Cell(130,$lar,$reg[$c],1,0,'R',0);
						//solo es un espacio
						$pdf->Cell(8,$lar,"",1,0,'R',0);
						//Muestra La Cantidad Total
                		$pdf->Cell(20,$lar,$cant[$c],1,0,'L',0);
						//Muestra la Descripción
                		$pdf->Cell(90,$lar,$des[$c],1,0,'L',0);
                		$pdf->ln($lar);
					}
					$cont = 0;
					$pdf->ln(3);
					$pdf->SetFillColor(240,240,240);
					$pdf->SetFont('','B');
					$lsCelda = mssql_fetch_field($result,0);
					$pdf->Cell(20,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,1);
					$pdf->Cell(10,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,2);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,3);
					$pdf->Cell(12,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,4);
					$pdf->Cell(6,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,5);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,6);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,7);
					$pdf->Cell(10,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,8);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,9);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,10);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,11);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,12);
					$pdf->Cell(25,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,13);
					$pdf->Cell(8,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,14);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,15);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,16);
					$pdf->Cell(25,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,17);
					$pdf->Cell(45,$lar,trim($lsCelda->name),1,0,'C',1);
					$lsCelda = mssql_fetch_field($result,18);
					$pdf->Cell(15,$lar,trim($lsCelda->name),1,0,'C',1);
					$pdf->ln($lar);
				}
            }
            $pdf->Output();
        }
    }
?>
