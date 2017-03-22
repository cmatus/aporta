<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    include("createzip.php");
    
    $lsPlanta = $HTTP_GET_VARS["PLA"];
    
    $lsSQL = "sp907610004_cmm_correccionmonetaria @planta = '".$lsPlanta."', @ano = '".$lsAno."'";
    $result = mssql_query($lsSQL);
    
    $lsArchivo = "Correccion_".$lsAno."_".$lsPlanta."_xls";
    $lsArchiv2 = "Correccion_".$lsAno."_".$lsPlanta."_pdf";    
    $handle    = fopen($lsArchivo.".xls","w");
    
    define('FPDF_FONTPATH','fpdf/font/');
    require('fpdf/fpdf.php');
    
    class PDF extends FPDF{
        
        function Header(){
            
            global $lsPlanta;
            global $lsAno;
            
            $this->SetFont('Times','BU',15);
            $this->MultiCell(278,5,"CORRECCION MONETARIA ".trim($lsAno)." ".$lsPlanta,"","C");
            $this->Ln();        
            $this->SetFont('Times','B',8);
                        
            $this->Cell(12,3,"Planta","1","","C");
            $this->Cell(19,3,"Artículo","1","","C");
            $this->Cell(9,3,"Proc.","1","","C");
            $this->Cell(12,3,"Moneda","1","","C");
            $this->Cell(17,3,"Nº Docto.","1","","C");
            $this->Cell(15,3,"Fecha","1","","C");
            $this->Cell(17,3,"P/O","1","","C");
            $this->Cell(17,3,"Referencia","1","","C");
            $this->Cell(15,3,"Saldo","1","","C");
            $this->Cell(15,3,"Aduanero","1","","C");
            $this->Cell(15,3,"Directo","1","","C");
            $this->Cell(15,3,"Elegido","1","","C");
            $this->Cell(15,3,"Reposic.","1","","C");
            $this->Cell(17,3,"Factor","1","","C");
            $this->Cell(15,3,"Reval.(U)","1","","C");
            $this->Cell(15,3,"Reval.","1","","C");
            $this->Cell(15,3,"C.M.","1","","C");
            $this->Cell(15,3,"Semestre","1","","C");
            
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
    <tr bgcolor='silver'>
    <td align='center'>&nbsp;<b>Tipo</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Planta</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Artículo</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Proc. Art.</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Moneda</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Nº Docto.</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Fecha</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>P/O</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Referencia</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Saldo/Cant.</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Costo Aduanero</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Costo Directo</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Elegido</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Costo Rep.</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Factor</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Rep. Reval. (Unit)</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Rep. Reval.</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>C.M.</b>&nbsp;</td>
    <td align='center'>&nbsp;<b>Semestre</b>&nbsp;</td>
    </tr>");
    
    $liSaldo    = 0;
    $lsAnterior = "";
    $lbFlag     = true;
    $liMaximo   = 0;
    $liUltimo   = 0;
    $lbPrimero  = true;
    $lsSemestre = 0;
    
    $pdf = new PDF();
    $pdf->FPDF('L','mm',"A4");
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    $pdf->SetFont("Times","",8);
    
    $lbSi = true;
    $lsXXX_Saldo = 0;
    while($row = mssql_fetch_array($result)){
        
        if(trim($row["tipo"])=="2"){
            fwrite($handle,"
            <tr bgcolor='yellow'>
            <td><b>".trim($row["tipo"])."</b></td>
            <td><b>".trim($row["planta"])."</b></td>
            <td><b>".trim($row["articulo"])."</b></td>
            <td><b>".trim($row["procedencia"])."</b></td>
            <td><b>".trim($row["moneda"])."</b></td>
            <td><b>".trim($row["docto_num"])."</b></td>
            <td><b>".trim($row["docto_fec"])."</b></td>
            <td><b>".trim($row["po"])."</b></td>
            <td><b>".trim($row["referencia"])."</b></td>
            <td><b>".trim($row["saldo"])."</b></td>
            <td><b>".trim($row["sli_total"])."</b></td>
            <td><b>".trim($row["cto_directo"])."</b></td>
            <td><b>".trim($row["cto_elegido"])."</b></td>
            <td><b>".trim($row["cto_reposicion"])."</b></td>
            <td><b>".trim($row["factor"])."</b></td>
            <td><b>".trim($row["cto_reval"])."</b></td>
            <td><b>".trim($row["cto_reval_tot"])."</b></td>
            <td><b>".trim($row["correccion"])."</b></td>
            <td><b>".trim($row["semestre"])."</b></td>
            </tr>");
        } else{
            fwrite($handle,"
            <tr bgcolor='white'>
            <td>".trim($row["tipo"])."</td>
            <td>".trim($row["planta"])."</td>
            <td>".trim($row["articulo"])."</td>
            <td>".trim($row["procedencia"])."</td>
            <td>".trim($row["moneda"])."</td>
            <td>".trim($row["docto_num"])."</td>
            <td>".trim($row["docto_fec"])."</td>
            <td>".trim($row["po"])."</td>
            <td>".trim($row["referencia"])."</td>
            <td>".trim($row["saldo"])."</td>
            <td>".trim($row["sli_total"])."</td>
            <td>".trim($row["cto_directo"])."</td>
            <td>".trim($row["cto_elegido"])."</td>
            <td>".trim($row["cto_reposicion"])."</td>
            <td>".trim($row["factor"])."</td>
            <td>".trim($row["cto_reval"])."</td>
            <td>".trim($row["cto_reval_tot"])."</td>
            <td>".trim($row["correccion"])."</td>
            <td>".trim($row["semestre"])."</td>
            </tr>");
        }
        
        $pdf->Cell(12,4,trim($row["planta"]),"1","","C");
        $pdf->Cell(19,4,trim($row["articulo"]),"1","","C");
        $pdf->Cell(9,4,trim($row["procedencia"]),"1","","C");
        $pdf->Cell(12,4,trim($row["moneda"]),"1","","C");
        $pdf->Cell(17,4,trim($row["docto_num"]),"1","","C");
        $pdf->Cell(15,4,substr(trim($row["docto_fec"]),0,10),"1","","C");
        $pdf->Cell(17,4,trim($row["po"]),"1","","R");
        $pdf->Cell(17,4,trim($row["referencia"]),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["saldo"]),0),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["sli_total"]),0),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["cto_directo"]),0),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["cto_elegido"]),0),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["cto_reposicion"]),0),"1","","R");
        $pdf->Cell(17,4,trim($row["factor"]),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["cto_reval"]),0),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["cto_reval_tot"]),0),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["correccion"]),0),"1","","R");
        $pdf->Cell(15,4,number_format(trim($row["semestre"]),0),"1","","R");
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
