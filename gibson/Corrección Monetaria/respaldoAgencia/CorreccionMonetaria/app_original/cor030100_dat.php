<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    include("createzip.php");
    
    $lsPlanta = $HTTP_GET_VARS["PLA"];
    
    $lsSQL = "sp907610004_cmm_librocompras @planta = '".$lsPlanta."', @ano = '".$lsAno."'";
    $result = mssql_query($lsSQL);
    
    $lsArchivo = "LibroCompras_".$lsAno."_".$lsPlanta."_xls";    
    $lsArchiv2 = "LibroCompras_".$lsAno."_".$lsPlanta."_pdf";
    $handle    = fopen($lsArchivo.".xls","w");
    
    define('FPDF_FONTPATH','fpdf/font/');
    require('fpdf/fpdf.php');
    
    class PDF extends FPDF{
        
        function Header(){
            
            global $lsPlanta;
            global $lsAno;
            
            $this->SetFont('Times','BU',15);
            $this->MultiCell(278,5,"LIBRO DE COMPRAS ".trim($lsAno)." ".$lsPlanta,"","C");
            $this->Ln();        
            $this->SetFont('Times','B',7);
            
            $this->Cell(15,3,"Artículo","1","","C");
            $this->Cell(7,3,"Bod","1","","C");
            $this->Cell(8,3,"Cant","1","","C");
            $this->Cell(8,3,"Saldo","1","","C");
            $this->Cell(5,3,"UM","1","","C");
            $this->Cell(5,3,"Mon","1","","C");
            $this->Cell(8,3,"Mes","1","","C");
            $this->Cell(11,3,"Fecha","1","","C");
            $this->Cell(13,3,"Documento","1","","C");
            $this->Cell(13,3,"Referencia","1","","C");
            $this->Cell(11,3,"Cod.Prov.","1","","C");
            $this->Cell(17,3,"Proveedor","1","","C");
            $this->Cell(13,3,"P/O","1","","C");
            $this->Cell(7,3,"Emb","1","","C");
            $this->Cell(10,3,"SAP","1","","C");
            $this->Cell(6,3,"Mon","1","","C");
            $this->Cell(11,3,"Pago","1","","C");
            $this->Cell(8,3,"Camb","1","","C");
            $this->Cell(9,3,"Cto","1","","C");
            $this->Cell(9,3,"Fac","1","","C");
            $this->Cell(9,3,"Desemb","1","","C");
            $this->Cell(9,3,"Dº","1","","C");
            $this->Cell(9,3,"Gtos.","1","","C");
            $this->Cell(9,3,"Otros","1","","C");
            $this->Cell(9,3,"Hon","1","","C");
            $this->Cell(9,3,"FOB","1","","C");
            $this->Cell(9,3,"Fle","1","","C");
            $this->Cell(9,3,"Seg","1","","C");
            $this->Cell(9,3,"SLI","1","","C");
            
            $this->Ln();
            
        }
        
        function Footer(){
            $this->SetY(-20);
            $this->SetFont('Times','B',8);
            $this->Cell(0,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
        }
        
    }
    
    fwrite($handle,"<table>");
    fwrite($handle,"
    <tr>
        <td align='center'>&nbsp;<b>Artículo</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Bodega</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Cantidad</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Saldo</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>U/M</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Moneda origen</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Mes</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Fecha ingreso bodega</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Documento</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Referencia</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Cod. Proveedor</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Proveedor</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>P/O</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Embarque</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Costo unitario SAP</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Moneda</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Fecha pago</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Tipo cambio</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Costo unitario (moneda)</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Costo unitario factura</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Desembolsos</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Derechos</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Gtos. despacho</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Otros Gastos</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Honorarios</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>FOB</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Flete</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Seguro</b>&nbsp;</td>
        <td align='center'>&nbsp;<b>Costo unitario SLI</b>&nbsp;</td>
    </tr>");
    
    $pdf = new PDF();
    $pdf->FPDF('L','mm',"A4");
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    $pdf->SetFont("Times","",6);
    
    fwrite($handle,$lsLinea);
    while($row = mssql_fetch_array($result)){
        
        fwrite($handle,"
        <tr>
            <td>".trim($row["articulo"])."</td>
            <td>".trim($row["bodega"])."</td>
            <td>".trim($row["cantidad"])."</td>
            <td>".trim($row["saldo"])."</td>
            <td>".trim($row["unidad"])."</td>
            <td>".trim($row["moneda"])."</td>
            <td>".trim($row["mes"])."</td>
            <td>".trim($row["docto_fec"])."</td>
            <td>".trim($row["docto_num"])."</td>
            <td>".trim($row["referencia"])."</td>
            <td>".trim($row["cod_proveedor"])."</td>
            <td>".trim($row["proveedor"])."</td>
            <td>".trim($row["po"])."</td>
            <td>".trim($row["embarque"])."</td>
            <td>".trim($row["costo"])."</td>
            <td>".trim($row["id_moneda"])."</td>
            <td>".trim($row["fecha_pago"])."</td>
            <td>".trim($row["tipo_cambio"])."</td>
            <td>".trim($row["valor_factura_mon"])."</td>
            <td>".trim($row["Sli_Total_Factura"])."</td>
            <td>".trim($row["Sli_Desembolsos"])."</td>
            <td>".trim($row["Sli_Flete_Interno"])."</td>
            <td>".trim($row["Sli_Gtos_Despacho"])."</td>
            <td>".trim($row["Sli_Otros_Gastos"])."</td>
            <td>".trim($row["Sli_Honorarios"])."</td>
            <td>".trim($row["Sli_FOB"])."</td>
            <td>".trim($row["Sli_Flete"])."</td>
            <td>".trim($row["Sli_Seguro"])."</td>
            <td>".trim($row["Sli_Total"])."</td>
        </tr>");
        
        $pdf->Cell(15,3,trim($row["articulo"]),"1","","R");
        $pdf->Cell(7,3,trim($row["bodega"]),"1","","C");
        $pdf->Cell(8,3,number_format(trim($row["cantidad"]),0),"1","","R");
        $pdf->Cell(8,3,number_format(trim($row["saldo"]),0),"1","","R");
        $pdf->Cell(5,3,trim($row["unidad"]),"1","","C");
        $pdf->Cell(5,3,trim($row["moneda"]),"1","","C");
        $pdf->Cell(8,3,trim($row["mes"]),"1","","R");
        $pdf->Cell(11,3,trim($row["docto_fec"]),"1","","C");
        $pdf->Cell(13,3,trim($row["docto_num"]),"1","","R");
        $pdf->Cell(13,3,trim($row["referencia"]),"1","","R");
        $pdf->Cell(11,3,trim($row["cod_proveedor"]),"1","","R");
        $pdf->Cell(17,3,substr(trim($row["proveedor"]),0,10),"1","","L");
        $pdf->Cell(13,3,trim($row["po"]),"1","","R");
        $pdf->Cell(7,3,trim($row["embarque"]),"1","","R");
        $pdf->Cell(10,3,number_format(trim($row["costo"]),0),"1","","R");
        $pdf->Cell(6,3,substr(trim($row["id_moneda"]),0,3),"1","","L");
        $pdf->Cell(11,3,trim($row["fecha_pago"]),"1","","C");
        $pdf->Cell(8,3,number_format(trim($row["tipo_cambio"]),2),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["valor_factura_mon"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Total_Factura"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Desembolsos"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Flete_Interno"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Gtos_Despacho"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Otros_Gastos"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Honorarios"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_FOB"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Flete"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Seguro"]),0),"1","","R");
        $pdf->Cell(9,3,number_format(trim($row["Sli_Total"]),0),"1","","R");
        $pdf->Ln();
        
    }
    fwrite($handle,"</table>");
    fclose($handle);
    
    $pdf->Output($lsArchiv2.".pdf");
    
    $cont = array($lsArchivo.".xls"=> file_get_contents($lsArchivo.".xls"));
    createzip($cont,$lsArchivo.".zip") or die("Error: al construir el ZIP.");
    unlink($lsArchivo.".xls");
    
    $cont = array($lsArchiv2.".pdf"=> file_get_contents($lsArchiv2.".pdf"));
    createzip($cont,$lsArchiv2.".zip") or die("Error: al construir el ZIP.");
    unlink($lsArchiv2.".pdf");
    
?>
