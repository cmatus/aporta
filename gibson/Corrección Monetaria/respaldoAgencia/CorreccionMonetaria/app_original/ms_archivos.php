<?

include("createzip.php");

define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');

set_time_limit(0);

class PDF extends FPDF{
    
    function Header(){
        
        global $lsPlanta;
        global $lsMes;
        global $liAncho;
        
        switch(substr($lsMes,4,2)){
            case "01":
                $lsTit_Mes = "Enero";
                break;
            case "02":
                $lsTit_Mes = "Febrero";
                break;
            case "03":
                $lsTit_Mes = "Marzo";
                break;
            case "04":
                $lsTit_Mes = "Abril";
                break;
            case "05":
                $lsTit_Mes = "Mayo";
                break;
            case "06":
                $lsTit_Mes = "Junio";
                break;
            case "07":
                $lsTit_Mes = "Julio";
                break;
            case "08":
                $lsTit_Mes = "Agosto";
                break;
            case "09":
                $lsTit_Mes = "Septiembre";
                break;
            case "10":
                $lsTit_Mes = "Octubre";
                break;
            case "11":
                $lsTit_Mes = "Noviembre";
                break;
            case "12":
                $lsTit_Mes = "Diciembre";
                break;
        }
        
        $this->SetFont('Times','BU',15);
        $this->MultiCell(278,5,"LIBRO DE EXISTENCIAS ".strtoupper($lsTit_Mes)." ".trim($lsAno)." ".$lsPlanta,"","C");
        $this->Ln();
        
        $this->SetFont('Times','B',7);
        $this->Cell($liAncho,3,"","","","C");
        $this->Cell(17,3,"Artículo","1","","C");
        $this->Cell(8,3,"Bod","1","","C");
        $this->Cell(8,3,"Cant","1","","C");
        $this->Cell(8,3,"Saldo","1","","C");
        $this->Cell(8,3,"Unid","1","","C");
        $this->Cell(13,3,"Valor","1","","C");
        $this->Cell(6,3,"Mon","1","","C");
        $this->Cell(13,3,"C.(SAP)","1","","C");
        $this->Cell(13,3,"C.(SLI)","1","","C");
        $this->Cell(13,3,"C.(PPP)","1","","C");
        $this->Cell(32,3,"Movimiento","1","","C");
        $this->Cell(15,3,"Documento","1","","C");
        $this->Cell(13,3,"Fecha","1","","C");
        $this->Cell(18,3,"Referencia","1","","C");
        $this->Cell(55,3,"Proveedor","1","","C");
        $this->Cell(15,3,"P/O","1","","C");
        $this->Cell(10,3,"Emb","1","","C");
        $this->Ln();
        
    }
    
    function Footer(){
        $this->SetY(-20);
        $this->SetFont('Times','B',8);
        $this->Cell(0,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
    }
    
}

function GeneraPDF($iPlanta,$iMes){

    $lsPlanta = $iPlanta;
    $lsMes    = $iMes;
    
    $dbh = mssql_connect("jupiter","sis_sli","sliusr") or die ('I cannot connect to the database because: ' . mssql_error());
    mssql_select_db("personalizados");
        
    $lsSQL = "
    DECLARE	@planta VARCHAR(6)
    DECLARE	@mes    VARCHAR(6)
    
    SET @planta = '".trim($lsPlanta)."'
    SET @mes    = '".trim($lsMes)."'
    
    SELECT	1					tipo,
    		articulo			articulo,
    		ISNULL(bodega,'')	bodega,
    		cantidad			cantidad,
    		saldo               saldo,
    		unidad				unidad,
    		valor				valor,
    		moneda				moneda,
    		costo				costo,
    		sli_total			sli_total,
    		ppp					ppp,
    		mov_tipo			mov_tipo,
    		mov_desc			mov_desc,
    		docto_num			docto_num,
    		mes					mes,
    		CONVERT(CHAR(10),docto_fec,103) docto_fec,
    		docto_fec fecha,
    		referencia			referencia,
    		cod_proveedor		cod_proveedor,
    		proveedor			proveedor,
    		po					po,
    		embarque			embarque
    FROM	[907610004_cmm_libroexistencias]
    WHERE	planta = @planta AND
            mes    = @mes
    UNION	ALL
    SELECT	1 tipo,
    		articulo,
    		ISNULL(bodega,''),
    		cantidad,
    		saldo,
    		unidad,
    		valor,
    		moneda,
    		costo,
    		sli_total,
    		ppp,
    		mov_tipo,
    		mov_desc,
    		docto_num,
    		mes,
    		CONVERT(CHAR(10),docto_fec,103) docto_fec,
    		docto_fec fecha,
    		referencia,
    		cod_proveedor,
    		proveedor,
    		po,
    		embarque
    FROM	[907610004_cmm_SaldosIniciales]
    WHERE	planta = @planta AND
            mes    = @mes
    UNION	ALL
    SELECT	1 tipo,
    		articulo,
    		ISNULL(bodega,''),
    		cantidad,
    		saldo,
    		unidad,
    		valor,
    		moneda,
    		costo,
    		sli_total,
    		ppp,
    		mov_tipo,
    		mov_desc,
    		docto_num,
    		mes,
    		CONVERT(CHAR(10),docto_fec,103) docto_fec,
    		docto_fec fecha,
    		referencia,
    		cod_proveedor,
    		proveedor,
    		po,
    		embarque
    FROM	[907610004_cmm_SaldosFinales]
    WHERE	planta = @planta AND
            mes    = @mes
    UNION	ALL
    SELECT	2 tipo,
    		articulo,
    		'',
    		max(saldo),
    		MAX(saldo),
    		'',
    		sum(saldo*costo),
    		'',
    		sum(saldo*costo),
    		sum(saldo*sli_total),
    		sum(saldo*ppp),
    		mov_tipo,
    		max(mov_desc),
    		'',
    		@mes,
    		MIN(CONVERT(CHAR(10),docto_fec,103)) docto_fec,
    		MIN(docto_fec) fecha,
    		'',
    		'',
    		'',
    		'',
    		''
    FROM	[907610004_cmm_SaldosIniciales]
    WHERE	planta = @planta AND
            mes    = @mes
    GROUP	BY
    		articulo,
    		mov_tipo
    UNION	ALL
    SELECT	2 tipo,
    		articulo,
    		'',
    		sum(cantidad),
    		max(saldo),
    		'',
    		sum(valor),
    		'',
    		sum(case when mov_tipo<>'P/C' then cantidad*costo else valor end),
    		sum(case when mov_tipo<>'P/C' then cantidad*sli_total else valor end),
    		sum(case when mov_tipo<>'P/C' then cantidad*ppp else valor end),
    		mov_tipo,
    		max(mov_desc),
    		'',
    		@mes,
    		MAX(CONVERT(CHAR(10),docto_fec,103)) docto_fec,
    		MAX(docto_fec) fecha,
    		'',
    		'',
    		'',
    		'',
    		''
    FROM	[907610004_cmm_libroexistencias]
    WHERE	planta = @planta AND
            mes    = @mes
    GROUP	BY
    		articulo,
    		mov_tipo
    UNION	ALL
    SELECT	2 tipo,
    		articulo,
    		'',
    		max(saldo),
    		max(saldo),
    		'',
    		sum(saldo*costo),
    		'',
    		sum(saldo*costo),
    		sum(saldo*sli_total),
    		sum(saldo*ppp),
    		mov_tipo,
    		max(mov_desc),
    		'',
    		@mes,
    		MAX(CONVERT(CHAR(10),docto_fec,103)) docto_fec,
    		MAX(docto_fec) fecha,
    		'',
    		'',
    		'',
    		'',
    		''
    FROM	[907610004_cmm_SaldosFinales]
    WHERE	planta = @planta AND
            mes    = @mes
    GROUP	BY
    		articulo,
    		mov_tipo
    ORDER	BY
    		articulo,
    		tipo,
    		mes,
    		fecha,
    		mov_tipo";
    $result = mssql_query($lsSQL);
    
    $lsArc_Libro = "LibroExistencias_".$lsMes."_".$lsPlanta."_pdf";
    $liAncho = 6;
    
    switch(substr($lsMes,4,2)){
        case "01":
            $lsTit_Mes = "Enero";
            break;
        case "02":
            $lsTit_Mes = "Febrero";
            break;
        case "03":
            $lsTit_Mes = "Marzo";
            break;
        case "04":
            $lsTit_Mes = "Abril";
            break;
        case "05":
            $lsTit_Mes = "Mayo";
            break;
        case "06":
            $lsTit_Mes = "Junio";
            break;
        case "07":
            $lsTit_Mes = "Julio";
            break;
        case "08":
            $lsTit_Mes = "Agosto";
            break;
        case "09":
            $lsTit_Mes = "Septiembre";
            break;
        case "10":
            $lsTit_Mes = "Octubre";
            break;
        case "11":
            $lsTit_Mes = "Noviembre";
            break;
        case "12":
            $lsTit_Mes = "Diciembre";
            break;
    }
    
    $pdf = new PDF();
	$pdf->FPDF('L','mm',"A4");
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFont("Times","",7);
	while($row = mssql_fetch_array($result)){
        
        if(trim($row["tipo"])=="1"){
            
            $lsBorde = "";
            if(trim($row["mov_tipo"])=="000"){
                $lsBorde = "T";
            } elseif(trim($row["mov_tipo"])=="ZZZ"){
                $lsBorde = "B";
            }
            
            $pdf->Cell($liAncho,3,"","","","C");
            $pdf->Cell(17,3,trim($row["articulo"]),"RL".$lsBorde,"","R");
            $pdf->Cell(8,3,trim($row["bodega"]),"R".$lsBorde,"","L");
            $pdf->Cell(8,3,number_format(trim($row["cantidad"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(8,3,number_format(trim($row["saldo"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(8,3,trim($row["unidad"]),"R".$lsBorde,"","L");
            $pdf->Cell(13,3,number_format(trim($row["valor"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(6,3,trim($row["moneda"]),"R".$lsBorde,"","R");
            $pdf->Cell(13,3,number_format(trim($row["costo"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(13,3,number_format(trim($row["sli_total"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(13,3,number_format(trim($row["ppp"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(7,3,trim($row["mov_tipo"]),"R".$lsBorde,"","R");
            $pdf->Cell(25,3,trim($row["mov_desc"]),"R".$lsBorde,"","L");
            $pdf->Cell(15,3,trim($row["docto_num"]),"R".$lsBorde,"","R");
            $pdf->Cell(13,3,trim($row["docto_fec"]),"R".$lsBorde,"","C");
            $pdf->Cell(18,3,trim($row["referencia"]),"R".$lsBorde,"","R");
            $pdf->Cell(10,3,trim($row["cod_proveedor"]),"R".$lsBorde,"","R");
            $pdf->Cell(45,3,trim($row["proveedor"]),"R".$lsBorde,"","L");
            $pdf->Cell(15,3,trim($row["po"]),"R".$lsBorde,"","R");
            $pdf->Cell(10,3,trim($row["embarque"]),"R".$lsBorde,"","R");
            $pdf->Ln();
            
            if(trim($row["mov_tipo"])=="ZZZ"){
                $pdf->Cell(10,3,"","","","C");
                $pdf->Ln();
            }
            
        } else{
            
            $lsBorde = "";
            if(trim($row["mov_tipo"])=="000"){
                $lsBorde = "T";
            } elseif(trim($row["mov_tipo"])=="ZZZ"){
                $lsBorde = "B";
            }
            
            $pdf->Cell($liAncho,3,"","","","C");
            $pdf->Cell(17,3,"","","","R");
            $pdf->Cell(8,3,"","","","L");
            $pdf->Cell(8,3,number_format(trim($row["cantidad"]),0),"LR".$lsBorde,"","R");
            $pdf->Cell(8,3,number_format(trim($row["saldo"]),0),"LR".$lsBorde,"","R");
            $pdf->Cell(8,3,trim($row["unidad"]),"R".$lsBorde,"","L");
            $pdf->Cell(13,3,number_format(trim($row["valor"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(6,3,trim($row["moneda"]),"R".$lsBorde,"","R");
            $pdf->Cell(13,3,number_format(trim($row["costo"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(13,3,number_format(trim($row["sli_total"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(13,3,number_format(trim($row["ppp"]),0),"R".$lsBorde,"","R");
            $pdf->Cell(7,3,trim($row["mov_tipo"]),"R".$lsBorde,"","R");
            $pdf->Cell(25,3,trim($row["mov_desc"]),"R".$lsBorde,"","L");
            $pdf->Cell(15,3,"","","","R");
            $pdf->Cell(13,3,"","","","C");
            $pdf->Cell(18,3,"","","","R");
            $pdf->Cell(10,3,"","","","R");
            $pdf->Cell(45,3,"","","","L");
            $pdf->Cell(15,3,"","","","R");
            $pdf->Cell(10,3,"","","","R");
            $pdf->Ln();
            
            if(trim($row["mov_tipo"])=="ZZZ"){
                $pdf->Cell(10,3,"","","","C");
                $pdf->Ln();
                $pdf->Cell($liAncho,3,"","","","C");
                $pdf->Cell(17,3,"Artículo","1","","C");
                $pdf->Cell(8,3,"Bod","1","","C");
                $pdf->Cell(8,3,"Cant","1","","C");
                $pdf->Cell(8,3,"Saldo","1","","C");
                $pdf->Cell(8,3,"Unid","1","","C");
                $pdf->Cell(13,3,"Valor","1","","C");
                $pdf->Cell(6,3,"Mon","1","","C");
                $pdf->Cell(13,3,"C.(SAP)","1","","C");
                $pdf->Cell(13,3,"C.(SLI)","1","","C");
                $pdf->Cell(13,3,"C.(PPP)","1","","C");
                $pdf->Cell(32,3,"Movimiento","1","","C");
                $pdf->Cell(15,3,"Documento","1","","C");
                $pdf->Cell(13,3,"Fecha","1","","C");
                $pdf->Cell(18,3,"Referencia","1","","C");
                $pdf->Cell(55,3,"Proveedor","1","","C");
                $pdf->Cell(15,3,"P/O","1","","C");
                $pdf->Cell(10,3,"Emb","1","","C");
                $pdf->Ln();
            }
            
        }
	}
	
    $lsSQL = "
    SELECT	FIN.planta,
            SUM(FIN.saldo) saldo,
            SUM(FIN.valor) sap,
            SUM(FIN.sli_total*FIN.saldo) sli,
            SUM(FIN.ppp_acumulado) ppp
    FROM	PERSONALIZADOS..[907610004_cmm_saldosfinales] FIN
    WHERE	FIN.mes = '".$lsMes."' AND
            FIN.planta = '".$lsPlanta."' AND
            ISNULL(FIN.saldo,0) <> 0
    GROUP	BY
    		FIN.planta
    ORDER	BY
    		FIN.planta";
    $result = mssql_query($lsSQL);
    
    $pdf->SetFont('Times','B',7);
    $pdf->Cell($liAncho,3,"","","","C");
    $pdf->Cell(8,3,"Saldo","1","","C");
    $pdf->Cell(13,3,"SAP","1","","C");
    $pdf->Cell(13,3,"SLI","1","","C");
    $pdf->Cell(13,3,"PPP","1","","C");
    $pdf->Ln();
    
    while($row = mssql_fetch_array($result)){
        $pdf->Cell($liAncho,3,"","","","C");
        $pdf->Cell(8,3,number_format(trim($row["saldo"]),0),"LR".$lsBorde,"","R");
        $pdf->Cell(13,3,number_format(trim($row["sap"]),0),"R".$lsBorde,"","R");
        $pdf->Cell(13,3,number_format(trim($row["sli"]),0),"R".$lsBorde,"","R");
        $pdf->Cell(13,3,number_format(trim($row["ppp"]),0),"R".$lsBorde,"","R");
        $pdf->Ln();
    }
	$pdf->Output($lsArc_Libro.".pdf");
	
    $cont = array($lsArc_Libro.".pdf"=> file_get_contents($lsArc_Libro.".pdf"));
    createzip($cont,$lsArc_Libro.".zip") or die("Error: al construir el ZIP.");
    unlink($lsArc_Libro.".pdf");

    echo $lsArc_Libro.".zip"."<br>";
    
}

function GeneraExcel($iPlanta,$iMes){

    $lsPlanta = $iPlanta;
    $lsMes    = $iMes;
    
    $dbh = mssql_connect("jupiter","sis_sli","sliusr") or die ('I cannot connect to the database because: ' . mssql_error());
    mssql_select_db("personalizados");
        
    $lsSQL = "sp907610004_cmm_libroexistencias @planta = '".$lsPlanta."', @mes = '".$lsMes."', @resumen = 0";
    $result = mssql_query($lsSQL);
    
    $lsArc_Libro = "LibroExistencias_".$lsMes."_".$lsPlanta."_xls";
    
    if(trim($x)=="1"){
        $handle = fopen($lsArc_Libro.".xls","w");
    } else{
        $handle = fopen($lsArc_Libro.".xls","w");
    }
    fwrite($handle,"<table cellpadding=0 cellspacing=0>");
    
    $lsLinea = "
    <tr>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Planta</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Artículo</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Bodega</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Cantidad</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Saldo</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Unidad</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Moneda</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Costo (SAP)</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Costo (SLI)</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Costo (PPP)</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Total (SAP)</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Total (SLI)</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Total (PPP)</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Cod. Mov.</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Movimiento</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Documento</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Mes</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Fecha</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Referencia</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Cod. Prov.</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Proveedor</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>P/O</b>&nbsp;</td>
    <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:1px solid black;border-left:1px solid black'>&nbsp;<b>Embarque</b>&nbsp;</td>
    </tr>";
    fwrite($handle,$lsLinea);
    
    $liCount = 0;
    while($row = mssql_fetch_array($result)){
                            
        switch(trim($row["tipo"])){
            case "1":
                if(trim($row["mov_desc"])=="SALDO INICIAL"||trim($row["mov_desc"])=="SALDO FINAL"){
                    $lsColor = "#ffff99";
                } else{
                    $lsColor = "white";
                }
                break;
            case "2":
                $lsColor = "#ccffff";
                break;                         
        }
        
        $lsBorde = "";
        $lsColor = "white";
        
        if(trim($row["mov_desc"])=="SALDO INICIAL"){
            $lsBorde = ";border-top:1px solid black";
            $lsColor = "lime";
        } elseif(trim($row["mov_desc"])=="SALDO FINAL"){
            $lsBorde = ";border-bottom:1px solid black";
            $lsColor = "lime";
        }
        
        if(trim($row["tipo"])=="2"){
            $lsLinea = "
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["cantidad"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["saldo"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["unidad"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["moneda"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["costo"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["sli_total"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["ppp"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["valor"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["sli_total"]*$row["cantidad"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["ppp_acumulado"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["mov_tipo"])."</td>
            <td style='border-right:1px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["mov_desc"])."</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>";
        } else{
            $lsLinea = "
            <tr>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".$lsPlanta."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["articulo"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["bodega"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["cantidad"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["saldo"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["unidad"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["moneda"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["costo"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["sli_total"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["ppp"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["valor"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["sli_total"]*$row["cantidad"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["ppp_acumulado"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["mov_tipo"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["mov_desc"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["docto_num"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["mes"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='center'>".trim($row["docto_fec"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["referencia"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["cod_proveedor"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["proveedor"])."</td>
            <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["po"])."</td>
            <td style='border-right:1px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["embarque"])."</td>
            </tr>";
        }
        fwrite($handle,$lsLinea);
        $liCount++;
        $lsAnterior = trim($row["articulo"]);
        
    }
    fwrite($handle,"</table>");
    fclose($handle);
    
    $cont = array($lsArc_Libro.".xls"=> file_get_contents($lsArc_Libro.".xls"));
    createzip($cont,$lsArc_Libro.".zip") or die("Error: al construir el ZIP.");
    unlink($lsArc_Libro.".xls");
    
    echo $lsArc_Libro.".zip";

}

//GeneraExcel("CL00","200701");

$laVar_1[0] = "CL00";
$laVar_1[1] = "CL10";
$laVar_1[2] = "CL11";
$laVar_1[3] = "CL70";
$laVar_1[4] = "CL71";
$laVar_1[5] = "CL7V";
$laVar_1[6] = "CL90";

$laVar_2[0]  = "200604";
$laVar_2[1]  = "200605";
$laVar_2[2]  = "200606";
$laVar_2[3]  = "200607";
$laVar_2[4]  = "200608";
$laVar_2[5]  = "200609";
$laVar_2[6]  = "200610";
$laVar_2[7]  = "200611";
$laVar_2[8]  = "200612";
$laVar_2[9]  = "200701";
$laVar_2[10] = "200702";
$laVar_2[11] = "200703";
$laVar_2[12] = "200704";
$laVar_2[13] = "200705";
$laVar_2[14] = "200706";
$laVar_2[15] = "200707";
$laVar_2[16] = "200708";
$laVar_2[17] = "200709";
$laVar_2[18] = "200710";
$laVar_2[19] = "200711";
$laVar_2[20] = "200712";

for($x=0;$x<7;$x++){
    for($y=0;$y<21;$y++){
        if(!file_exists("LibroExistencias_".$laVar_2[$y]."_".$laVar_1[$x]."_pdf.zip")){
            GeneraPDF($laVar_1[$x],$laVar_2[$y]);
        }
    }
}

?>
