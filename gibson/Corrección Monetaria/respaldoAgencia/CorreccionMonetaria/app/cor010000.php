<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: application/vnd.ms-excel");
    
    include("seguridad.php");
    
    define('FPDF_FONTPATH','fpdf/font/');
    require('fpdf/fpdf.php');
    
    //$lsAno    = $HTTP_GET_VARS["ANO"];
    $lsTipo   = $HTTP_GET_VARS["TIP"];
    $lsPlanta = $HTTP_GET_VARS["PLA"];
    
    class PDF extends FPDF{
        
        function Header(){
            
            global $lsTipo;
            global $lsPlanta;
            global $liAncho;
            
            switch($lsTipo){
            
                case 12:
            
                    $this->SetFont('Times','BU',15);
                    $this->MultiCell(278,5,"LIBRO DE COMPRAS ".trim($lsAno)." ".$lsPlanta,"","C");
                    $this->Ln();
                    
                    $this->SetFont('Times','B',6);
                    $this->Cell(15,3,"ARTICULO","1","","C");
                    $this->Cell(9,3,"BOD","1","","C");
                    $this->Cell(9,3,"CANT","1","","C");
                    $this->Cell(9,3,"UNID","1","","C");
                    $this->Cell(9,3,"MON","1","","C");
                    $this->Cell(9,3,"MES","1","","C");
                    $this->Cell(15,3,"FECHA","1","","C");
                    $this->Cell(17,3,"REFERENCIA","1","","C");
                    $this->Cell(10,3,"COD.","1","","C");
                    $this->Cell(40,3,"PROVEEDOR","1","","C");
                    $this->Cell(15,3,"P/O","1","","C");
                    $this->Cell(10,3,"EMB","1","","C");
                    $this->Cell(10,3,"COSTO","1","","C");
                    $this->Cell(10,3,"FACT.","1","","C");
                    $this->Cell(10,3,"DESEM","1","","C");
                    $this->Cell(10,3,"DERECHOS","1","","C");
                    $this->Cell(10,3,"GTOS.","1","","C");
                    $this->Cell(10,3,"OTROS.","1","","C");
                    $this->Cell(10,3,"HON","1","","C");
                    $this->Cell(10,3,"FOB","1","","C");
                    $this->Cell(10,3,"FLETE","1","","C");
                    $this->Cell(10,3,"SEGURO","1","","C");
                    $this->Cell(10,3,"TOTAL","1","","C");
                    break;
                    
                case 15: /* Saldos iniciales (PDF) */
                
                    $this->SetFont('Times','BU',15);
                    $this->MultiCell(278,5,"SALDOS INICIALES ".trim($lsAno)." ".$lsPlanta,"","C");
                    $this->Ln();
                    
                    $this->SetFont("Times","B",8);
                    $this->Cell(40,4,"","","","C");
                    $this->Cell(12,4,"PLANTA","1","","C");
                    $this->Cell(19,4,"ARTICULO","1","","C");
                    $this->Cell(15,4,"FECHA","1","","C");
                    $this->Cell(10,4,"MES","1","","C");
                    $this->Cell(15,4,"SALDO","1","","C");
                    $this->Cell(15,4,"SAP","1","","C");
                    $this->Cell(15,4,"SLI","1","","C");
                    $this->Cell(15,4,"PPP","1","","C");
                    $this->Cell(15,4,"REV","1","","C");
                    $this->Cell(15,4,"SAP","1","","C");
                    $this->Cell(15,4,"SLI","1","","C");
                    $this->Cell(15,4,"PPP","1","","C");
                    $this->Cell(15,4,"REV","1","","C");
                    break;
                    
                case 16: /* Saldos finales (PDF) */
                
                    $this->SetFont('Times','BU',15);
                    $this->MultiCell(278,5,"SALDOS FINALES ".trim($lsAno)." ".$lsPlanta,"","C");
                    $this->Ln();
                    
                    $this->SetFont("Times","B",8);
                    $this->Cell(40,4,"","","","C");
                    $this->Cell(12,4,"PLANTA","1","","C");
                    $this->Cell(19,4,"ARTICULO","1","","C");
                    $this->Cell(15,4,"FECHA","1","","C");
                    $this->Cell(10,4,"MES","1","","C");
                    $this->Cell(15,4,"SALDO","1","","C");
                    $this->Cell(15,4,"SAP","1","","C");
                    $this->Cell(15,4,"SLI","1","","C");
                    $this->Cell(15,4,"PPP","1","","C");
                    $this->Cell(15,4,"REV","1","","C");
                    $this->Cell(15,4,"SAP","1","","C");
                    $this->Cell(15,4,"SLI","1","","C");
                    $this->Cell(15,4,"PPP","1","","C");
                    $this->Cell(15,4,"REV","1","","C");
                    break;
                    
            }
            $this->Ln();
            
        }
        
        function Footer(){
            $this->SetY(-20);
            $this->SetFont('Times','B',8);
            $this->Cell(0,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
        }
        
    }
    
    switch($lsTipo){
        
        case 1: /* Facturas en tránsito SLI (PM) */
            
            $lsSQL = "
            SELECT	FAC.num_facturainterno,
            		FAC.num_facturaproveedor,
            		CONVERT(CHAR(10),FAC.fecha,103) fecha,
            		FAC.id_proveedor,
            		FAC.proveedor,
            		FAC.id_moneda,
            		fac.num_oc,
            		fac.num_embarque
            FROM	CLIENTES..factura_enc FAC LEFT OUTER JOIN PERSONALIZADOS..[907610004_cmm_libroexistencias] LIB on FAC.num_facturaproveedor = LIB.referencia
            		                          INNER JOIN      CLIENTES..division DIV ON FAC.id_pd = DIV.id_division
            WHERE	LIB.referencia IS NULL AND
                    LEFT(LIB.mes,4) = '".trim($lsAno)."' AND
            		FAC.id_cliente = '907610004' AND
            		FAC.fec_archivo IS NOT NULL AND
            		DIV.cod_division = '".$lsPlanta."' AND
                    FAC.id_cliente = '907610004'
            ORDER   BY
                    FAC.num_facturaproveedor";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr>
                <td align='center'>&nbsp;<b>INTERNO</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>REFERENCIA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>FECHA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>COD.PROV.</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>PROVEEDOR</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>O/C</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>EMBARQUE</b>&nbsp;</td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr>
                    <td>".trim($row["num_facturainterno"])."</td>
                    <td>".trim($row["num_facturaproveedor"])."</td>
                    <td>".trim($row["fecha"])."</td>
                    <td>".trim($row["id_proveedor"])."</td>
                    <td>".trim($row["proveedor"])."</td>
                    <td>".trim($row["num_oc"])."</td>
                    <td>".trim($row["num_embarque"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 2:
            
            $lsSQL = "
            SELECT	EMB.numembarque,
            		CONVERT(CHAR(10),EMB.fecembarque,103) fecembarque,
            		EMB.codproveedor,
            		EMB.nave,
            		CONVERT(CHAR(10),EMB.eta,103) eta,
            		EMB.codflete,
            		EMB.observacion
            FROM	CLIENTES..embarque EMB INNER JOIN CLIENTES..division DIV ON EMB.id_pd = DIV.id_division
            		                       LEFT OUTER JOIN CLIENTES..factura_enc FAC ON EMB.id_cliente = FAC.id_cliente AND EMB.numembarque = FAC.num_embarque
            WHERE	EMB.id_cliente = '907610004' AND
            		FAC.num_embarque IS NULL AND
            		EMB.fecembarque IS NOT NULL AND
            		DIV.cod_division = '".$lsPlanta."' AND
                    EMB.numembarque > 30000
            ORDER	BY
            		EMB.numembarque";
            $result = mssql_query($lsSQL);
            		
            echo "<table>";
            echo "
            <tr>
                <td align='center'>&nbsp;<b>Nº EMBARQUE</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>FECHA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>COD.PROV.</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>NAVE</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>ETA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>FLETE</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>OBSERVACION</b>&nbsp;</td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr>
                    <td>".trim($row["numembarque"])."</td>
                    <td>".trim($row["fecembarque"])."</td>
                    <td>".trim($row["codproveedor"])."</td>
                    <td>".trim($row["nave"])."</td>
                    <td>".trim($row["eta"])."</td>
                    <td>".trim($row["codflete"])."</td>
                    <td>".trim($row["observacion"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 3:
            
            $lsSQL = "
            SELECT	FAC.num_facturainterno,
            		FAC.num_facturaproveedor,
            		CONVERT(CHAR(10),FAC.fecha,103) fecha,
            		FAC.id_proveedor,
            		FAC.proveedor,
            		FAC.id_moneda,
            		fac.num_oc,
            FROM	CLIENTES..factura_enc FAC INNER JOIN CLIENTES..division DIV ON FAC.id_pd = DIV.id_division
            WHERE	(FAC.fecha IS NULL OR FAC.fecha = '19000101') AND
            		FAC.fec_archivo IS NOT NULL AND
            		DIV.cod_division = '".$lsPlanta."' AND
                    FAC.id_cliente = '907610004'";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr>
                <td align='center' colspan=2>&nbsp;<b>Nº FACTURA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>FECHA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>COD.PROV.</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>PROVEEDOR</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>O/C</b>&nbsp;</td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr>
                    <td>".trim($row["num_facturainterno"])."</td>
                    <td>".trim($row["num_facturaproveedor"])."</td>
                    <td>".trim($row["fecha"])."</td>
                    <td>".trim($row["id_proveedor"])."</td>
                    <td>".trim($row["proveedor"])."</td>
                    <td>".trim($row["num_oc"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 4:
            
            $lsSQL = "
            SELECT	FAC.num_facturainterno,
            		FAC.num_facturaproveedor,
            		CONVERT(CHAR(10),FAC.fecha,103) fecha,
            		FAC.id_proveedor,
            		FAC.proveedor,
            		FAC.id_moneda,
            		fac.num_oc
            FROM	CLIENTES..factura_enc FAC INNER JOIN CLIENTES..division DIV ON FAC.id_pd = DIV.id_division
            WHERE	(FAC.id_moneda IS NULL OR FAC.id_moneda = 0) AND
            		FAC.fec_archivo IS NOT NULL AND
            		DIV.cod_division = '".$lsPlanta."' AND
                    FAC.id_cliente = '907610004'";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr>
                <td align='center' colspan=2>&nbsp;<b>Nº FACTURA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>FECHA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>COD.PROV.</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>PROVEEDOR</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>O/C</b>&nbsp;</td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr>
                    <td>".trim($row["num_facturainterno"])."</td>
                    <td>".trim($row["num_facturaproveedor"])."</td>
                    <td>".trim($row["fecha"])."</td>
                    <td>".trim($row["id_proveedor"])."</td>
                    <td>".trim($row["proveedor"])."</td>
                    <td>".trim($row["num_oc"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 5:
            
            $lsSQL = "
            SELECT	FAC.num_facturainterno,
            		FAC.num_facturaproveedor,
            		CONVERT(CHAR(10),FAC.fecha,103) fecha,
            		FAC.id_proveedor,
            		FAC.proveedor,
            		FAC.id_moneda,
            		fac.num_oc
            FROM	CLIENTES..factura_enc FAC INNER JOIN CLIENTES..division DIV ON FAC.id_pd = DIV.id_division
            WHERE	FAC.num_embarque IS NULL AND
            		FAC.fec_archivo IS NOT NULL AND
            		DIV.cod_division = '".$lsPlanta."' AND
                    FAC.id_cliente = '907610004'";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr>
                <td align='center'>&nbsp;<b>INTERNO</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>REFERENCIA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>FECHA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>COD.PROV.</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>PROVEEDOR</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>O/C</b>&nbsp;</td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr>
                    <td>".trim($row["num_facturainterno"])."</td>
                    <td>".trim($row["num_facturaproveedor"])."</td>
                    <td>".trim($row["fecha"])."</td>
                    <td>".trim($row["id_proveedor"])."</td>
                    <td>".trim($row["proveedor"])."</td>
                    <td>".trim($row["num_oc"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 6:
        
            $lsSQL = "
            SELECT	FAC.num_facturainterno,
            		FAC.num_facturaproveedor,
            		CONVERT(CHAR(10),FAC.fecha,103) fecha,
            		FAC.id_proveedor,
            		FAC.proveedor,
            		FAC.id_moneda,
            		fac.num_embarque
            FROM	CLIENTES..factura_enc FAC INNER JOIN CLIENTES..division DIV ON FAC.id_pd = DIV.id_division
            WHERE	FAC.num_embarque IS NULL AND
            		FAC.fec_archivo IS NOT NULL AND
            		DIV.cod_division = '".$lsPlanta."' AND
                    FAC.id_cliente = '907610004'";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr>
                <td align='center'>&nbsp;<b>INTERNO</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>REFERENCIA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>FECHA</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>COD.PROV.</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>PROVEEDOR</b>&nbsp;</td>
                <td align='center'>&nbsp;<b>EMBARQUE</b>&nbsp;</td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr>
                    <td>".trim($row["num_facturainterno"])."</td>
                    <td>".trim($row["num_facturaproveedor"])."</td>
                    <td>".trim($row["fecha"])."</td>
                    <td>".trim($row["id_proveedor"])."</td>
                    <td>".trim($row["proveedor"])."</td>
                    <td>".trim($row["num_embarque"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 7:
            
            $lsSQL = "
            SELECT  LIB.planta,
                    LIB.articulo,
                    LIB.docto_num,
                    LIB.po,
                    convert(char(10),LIB.docto_fec,103) fecha,
                    LIB.cantidad,
                    LIB.costo,
                    LIB.valor,
                    LIB.cod_proveedor,
                    LIB.proveedor,
                    LIB.referencia,
                    LIB.mes,
                    LIB.descripcion
            FROM    [907610004_cmm_libroexistencias] LIB LEFT OUTER JOIN CLIENTES..Factura_Enc FAC ON RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(LIB.referencia)),20) = RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(FAC.num_facturaproveedor)),20) AND LIB.cod_proveedor = FAC.id_proveedor AND FAC.id_cliente = '907610004'
                                                         LEFT OUTER JOIN CLIENTES..Factura_Det DET ON FAC.num_facturainterno = DET.num_facturainterno AND FAC.id_cliente = DET.id_cliente AND LIB.articulo = DET.codigoarticulo
            WHERE   LIB.mov_tipo = '101' AND
                    LEFT(LIB.mes,4) = '".trim($lsAno)."' AND
                    FAC.num_facturaproveedor IS NULL AND
                    LIB.planta = '".$lsPlanta."' AND
                    LIB.proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
            ORDER   BY
                    LIB.proveedor,
                    LIB.cod_proveedor,
                    LIB.referencia";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr height=20>
            <td><b>PLANTA</b></td>
            <td><b>ARTICULO</b></td>
            <td><b>No. DOCTO.</b></td>
            <td><b>P/O</b></td>
            <td><b>FEC. DOCTO.</b></td>
            <td><b>COD. PROV.</b></td>
            <td><b>PROVEEDOR</b></td>
            <td><b>CANTIDAD</b></td>
            <td><b>COSTO</b></td>
            <td><b>VALOR</b></td>
            <td><b>REFERENCIA</b></td>
            <td><b>INTERNO</b></td>
            <td><b>NUEVO INT.</b></td>
            <td><b>PST. DATE</b></td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                $laDato = split("@",trim($row2["descripcion"]));
                echo "
                <tr height=20>
                <td>".trim($row["planta"])."</td>
                <td>".trim($row["articulo"])."</td>
                <td>".trim($row["docto_num"])."</td>
                <td>".trim($row["po"])."</td>
                <td>".trim($row["fecha"])."</td>
                <td>".trim($row["cod_proveedor"])."</td>
                <td>".strtoupper(trim($row["proveedor"]))."</td>
                <td>".number_format(trim($row["cantidad"]),0,"","")."</td>
                <td>".number_format(trim($row["costo"]),0,"","")."</td>
                <td>".number_format(trim($row["valor"]),0,"","")."</td>
                <td>".trim($row["referencia"])."</td>
                <td>".$laDato[0]."</td>
                <td>".$laDato[1]."</td>
                <td>".$laDato[2]."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 8:
            
            $lsSQL = "
            SELECT  LIB.planta,
                    LIB.articulo,
                    LIB.docto_num,
                    LIB.po,
                    convert(char(10),LIB.docto_fec,103) fecha,
                    LIB.cantidad,
                    LIB.costo,
                    LIB.valor,
                    LIB.cod_proveedor,
                    LIB.proveedor,
                    LIB.referencia,
                    FAC.num_facturainterno
            FROM    [907610004_cmm_libroexistencias] LIB INNER JOIN CLIENTES..Factura_Enc FAC ON LIB.referencia = FAC.num_facturaproveedor AND LIB.cod_proveedor = FAC.id_proveedor
            WHERE   LIB.mov_tipo = '101' AND
                    LEFT(LIB.mes,4) = '".trim($lsAno)."' AND
                    FAC.num_embarque IS NULL AND
                    LIB.planta = '".$lsPlanta."' AND
                    LIB.proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
            ORDER   BY
                    LIB.planta,
                    LIB.articulo";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr height=20>
            <td><b>PLANTA</b></td>
            <td><b>ARTICULO</b></td>
            <td><b>No. DOCTO.</b></td>
            <td><b>P/O</b></td>
            <td><b>FEC. DOCTO.</b></td>
            <td><b>COD. PROV.</b></td>
            <td><b>PROVEEDOR</b></td>
            <td><b>CANTIDAD</b></td>
            <td><b>COSTO</b></td>
            <td><b>VALOR</b></td>
            <td><b>REFERENCIA</b></td>
            <td><b>INTERNO</b></td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr height=20>
                <td>".trim($row["planta"])."</td>
                <td>".trim($row["articulo"])."</td>
                <td>".trim($row["docto_num"])."</td>
                <td>".trim($row["po"])."</td>
                <td>".trim($row["fecha"])."</td>
                <td>".trim($row["cod_proveedor"])."</td>
                <td>".strtoupper(trim($row["proveedor"]))."</td>
                <td>".number_format(trim($row["cantidad"]),0,"","")."</td>
                <td>".number_format(trim($row["costo"]),0,"","")."</td>
                <td>".number_format(trim($row["valor"]),0,"","")."</td>
                <td>".trim($row["referencia"])."</td>
                <td>".trim($row["num_facturainterno"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 9:
            
           $lsSQL = "
            SELECT  LIB.planta,
                    LIB.articulo,
                    LIB.docto_num,
                    LIB.po,
                    convert(char(10),LIB.docto_fec,103) fecha,
                    LIB.cantidad,
                    LIB.costo,
                    LIB.valor,
                    LIB.cod_proveedor,
                    LIB.proveedor,
                    LIB.referencia,
                    FAC.num_embarque
            FROM    [907610004_cmm_libroexistencias] LIB INNER JOIN  CLIENTES..Factura_Enc FAC ON RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(LIB.referencia)),20) = RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(FAC.num_facturaproveedor)),20) AND LIB.cod_proveedor = FAC.id_proveedor
                                                     LEFT OUTER JOIN SLI..apertura         APE ON FAC.id_cliente = APE.id_cliente AND FAC.num_embarque = APE.ref_cliente AND YEAR(APE.fechaape) >= 2006 AND APE.id_cliente = '907610004'
            WHERE   CONVERT(INT,FAC.num_embarque) > 30000 AND
                    LIB.mov_tipo = '101' AND
                    LEFT(LIB.mes,4) = '".trim($lsAno)."' AND
                    FAC.num_embarque IS NOT NULL AND
                    APE.ref_cliente IS NULL AND
                    LIB.planta = '".$lsPlanta."' AND
                    LIB.proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
            ORDER   BY
                    LIB.planta,
                    LIB.articulo";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr height=20>
            <td><b>PLANTA</b></td>
            <td><b>ARTICULO</b></td>
            <td><b>No. DOCTO.</b></td>
            <td><b>P/O</b></td>
            <td><b>FEC. DOCTO.</b></td>
            <td><b>COD. PROV.</b></td>
            <td><b>PROVEEDOR</b></td>
            <td><b>CANTIDAD</b></td>
            <td><b>COSTO</b></td>
            <td><b>VALOR</b></td>
            <td><b>REFERENCIA</b></td>
            <td><b>EMBARQUE</b></td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr height=20>
                <td>".trim($row["planta"])."</td>
                <td>".trim($row["articulo"])."</td>
                <td>".trim($row["docto_num"])."</td>
                <td>".trim($row["po"])."</td>
                <td>".trim($row["fecha"])."</td>
                <td>".trim($row["cod_proveedor"])."</td>
                <td>".strtoupper(trim($row["proveedor"]))."</td>
                <td>".number_format(trim($row["cantidad"]),0,"","")."</td>
                <td>".number_format(trim($row["costo"]),0,"","")."</td>
                <td>".number_format(trim($row["valor"]),0,"","")."</td>
                <td>".trim($row["referencia"])."</td>
                <td>".trim($row["num_embarque"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 10:
            
            $lsSQL = "
            SELECT	DISTINCT
                    ape.despacho,
            		ape.ref_cliente
            FROM	agencia..factura_cab fac INNER JOIN sli..apertura ape on fac.despacho = ape.despacho
            		                         LEFT OUTER JOIN clientes..embarque emb on RTRIM(LTRIM(ape.ref_cliente)) = RTRIM(LTRIM(emb.numembarque)) AND ape.id_cliente = emb.id_cliente
            WHERE	emb.numembarque IS NULL      AND
            		fac.id_cliente = '907610004' AND
            		left(ape.despacho,1) = 'I'   AND
            		year(ape.fechaape) = ".trim($lsPlanta)."
            ORDER   BY
                    ape.despacho";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr height=20>
            <td><b>DESPACHO</b></td>
            <td><b>REFERENCIA</b></td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr height=20>
                <td>".trim($row["despacho"])."</td>
                <td>".trim($row["ref_cliente"])."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 11: /* Libro compras XLS */
            
            $lsSQL = "
            SELECT	articulo			articulo,
            		ISNULL(bodega,'')	bodega,
            		cantidad			cantidad,
            		saldo               saldo,
            		unidad				unidad,
            		moneda				moneda,
            		mes					mes,
            		CONVERT(CHAR(10),docto_fec,103) docto_fec,
            		docto_fec                    fecha,
            		referencia			         referencia,
            		cod_proveedor		         cod_proveedor,
            		proveedor			         proveedor,
            		po					         po,
            		embarque			         embarque,
            		costo				         costo,
                    isnull(Sli_Total_Factura ,0) Sli_Total_Factura,
                    isnull(Sli_Desembolsos,0)    Sli_Desembolsos,
                    isnull(Sli_Flete_Interno,0)  Sli_Flete_Interno,
                    isnull(Sli_Gtos_Despacho,0)  Sli_Gtos_Despacho,
                    isnull(Sli_Otros_Gastos,0)   Sli_Otros_Gastos,
                    isnull(Sli_Honorarios,0)     Sli_Honorarios,
                    isnull(Sli_FOB,0)            Sli_FOB,
                    isnull(Sli_Flete,0)          Sli_Flete,
                    isnull(Sli_Seguro,0)         Sli_Seguro,
                    isnull(Sli_Total,0)          Sli_Total
            FROM	[907610004_cmm_libroexistencias]
            WHERE	planta = '".$lsPlanta."' AND
                    LEFT(mes,4) = '".trim($lsAno)."' AND
                    mov_tipo = '101'
            ORDER	BY
            		articulo,
            		mes,
            		fecha,
            		mov_tipo";
            $result = mssql_query($lsSQL);
            		
            echo "<table>";
            echo "
            <tr height=20>
            <td><b>ARTICULO</b></td>
            <td><b>BODEGA</b></td>
            <td><b>CANTIDAD</b></td>
            <td><b>SALDO</b></td>
            <td><b>UNIDAD</b></td>
            <td><b>MONEDA</b></td>
            <td><b>MES</b></td>
            <td><b>FECHA</b></td>
            <td><b>REFERENCIA</b></td>
            <td><b>COD. PROV.</b></td>
            <td><b>PROVEEDOR</b></td>
            <td><b>P/O</b></td>
            <td><b>EMBARQUE</b></td>
            <td><b>COSTO</b></td>
            <td><b>TOT. FACT.</b></td>
            <td><b>DESEMBOLSOS</b></td>
            <td><b>DERECHOS</b></td>
            <td><b>GTOS. DESP.</b></td>
            <td><b>OTROS. GTOS.</b></td>
            <td><b>HONORARIOS</b></td>
            <td><b>FOB</b></td>
            <td><b>FLETE</b></td>
            <td><b>SEGURO</b></td>
            <td><b>TOTAL</b></td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr height=20>
                <td>".trim($row["articulo"])."</td>
                <td>".trim($row["bodega"])."</td>
                <td>".trim($row["cantidad"])."</td>
                <td>".trim($row["saldo"])."</td>
                <td>".trim($row["unidad"])."</td>
                <td>".trim($row["moneda"])."</td>
                <td>".trim($row["mes"])."</td>
                <td>".trim($row["docto_fec"])."</td>
                <td>".trim($row["referencia"])."</td>
                <td>".trim($row["cod_proveedor"])."</td>
                <td>".trim($row["proveedor"])."</td>
                <td>".trim($row["po"])."</td>
                <td>".trim($row["embarque"])."</td>
                <td>".trim($row["costo"])."</td>
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
                </tr>";
            }
            echo "</table>";
            break;
            
        case 12: /* Libro compras PDF */
                
            $pdf = new PDF();
        	$pdf->FPDF('L','mm',"A4");
        	$pdf->AliasNbPages();
        	$pdf->AddPage();
        	
            $lsSQL = "
            SELECT	articulo			articulo,
            		ISNULL(bodega,'')	bodega,
            		cantidad			cantidad,
            		saldo               saldo,
            		unidad				unidad,
            		moneda				moneda,
            		mes					mes,
            		CONVERT(CHAR(10),docto_fec,103) docto_fec,
            		docto_fec                    fecha,
            		referencia			         referencia,
            		cod_proveedor		         cod_proveedor,
            		proveedor			         proveedor,
            		po					         po,
            		embarque			         embarque,
            		costo				         costo,
                    isnull(Sli_Total_Factura ,0) Sli_Total_Factura,
                    isnull(Sli_Desembolsos,0)    Sli_Desembolsos,
                    isnull(Sli_Flete_Interno,0)  Sli_Flete_Interno,
                    isnull(Sli_Gtos_Despacho,0)  Sli_Gtos_Despacho,
                    isnull(Sli_Otros_Gastos,0)   Sli_Otros_Gastos,
                    isnull(Sli_Honorarios,0)     Sli_Honorarios,
                    isnull(Sli_FOB,0)            Sli_FOB,
                    isnull(Sli_Flete,0)          Sli_Flete,
                    isnull(Sli_Seguro,0)         Sli_Seguro,
                    isnull(Sli_Total,0)          Sli_Total
            FROM	[907610004_cmm_libroexistencias]
            WHERE	planta = '".$lsPlanta."' AND
                    LEFT(mes,4) = '".trim($lsAno)."' AND
                    mov_tipo = '101'
            ORDER	BY
            		articulo,
            		mes,
            		docto_fec";
            $result = mssql_query($lsSQL);
        	
        	$pdf->SetFont("Times","",6);
        	while($row = mssql_fetch_array($result)){
                $pdf->Cell(15,3,trim($row["articulo"]),"1","","C");
                $pdf->Cell(9,3,trim($row["bodega"]),"1","","C");
                $pdf->Cell(9,3,number_format(trim($row["cantidad"]),0),"1","","R");
                $pdf->Cell(9,3,trim($row["unidad"]),"1","","C");
                $pdf->Cell(9,3,trim($row["moneda"]),"1","","C");
                $pdf->Cell(9,3,trim($row["mes"]),"1","","C");
                $pdf->Cell(15,3,trim($row["docto_fec"]),"1","","C");
                $pdf->Cell(17,3,trim($row["referencia"]),"1","","R");
                $pdf->Cell(10,3,trim($row["cod_proveedor"]),"1","","C");
                $pdf->Cell(40,3,trim($row["proveedor"]),"1","","L");
                $pdf->Cell(15,3,trim($row["po"]),"1","","R");
                $pdf->Cell(10,3,trim($row["embarque"]),"1","","C");
                $pdf->Cell(10,3,number_format(trim($row["costo"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Total_Factura"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Desembolsos"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Flete_Interno"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Gtos_Despacho"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Otros_Gastos"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Honorarios"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_FOB"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Flete"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Seguro"]),0),"1","","R");
                $pdf->Cell(10,3,number_format(trim($row["Sli_Total"]),0),"1","","R");
                $pdf->Ln();
        	}
            
            $pdf->Output();            
            break;
            
        case 13: /* Saldos iniciales */
        
            $lsSQL = "
            select	planta			planta,
            		articulo		articulo,
            		max(docto_fec)	docto_fec
            into	#tmp_2
            from	[907610004_cmm_libroexistencias]
            where	planta = '".trim($lsPlanta)."' AND
            		mov_tipo = '101' and
            		left(mes,4) = '2006'
            group	by
            		planta,
            		articulo
            
            select	LIB.planta		planta,
            		LIB.articulo	articulo,
            		max(LIB.id)		id
            into	#tmp_compra
            from	[907610004_cmm_libroexistencias] LIB INNER JOIN #tmp_2 TMP ON LIB.planta = TMP.planta AND LIB.articulo = TMP.articulo AND LIB.docto_fec = TMP.docto_fec
            where	LIB.planta = '".trim($lsPlanta)."' AND
            		LIB.mov_tipo = '101' and
            		left(LIB.mes,4) = '2006'
            group	by
            		LIB.planta,
            		LIB.articulo
            
            select	LIB.planta,
            		LIB.articulo,
            		LIB.costo,
            		LIB.sli_total,
            		LIB.ppp
            INTO	#tmp_sal_compra
            from	[907610004_cmm_libroexistencias] LIB INNER JOIN #tmp_compra TMP ON LIB.planta = TMP.planta AND LIB.articulo = TMP.articulo AND LIB.id = TMP.id
            where	LIB.planta = '".trim($lsPlanta)."' AND
            		LIB.mov_tipo = '101' and
            		left(LIB.mes,4) = '2006'
            
            SELECT	INI.planta							planta,
            		INI.articulo						articulo,
            		CONVERT(CHAR(10),INI.docto_fec,103)	fecha,
            		INI.mes								mes,
            		INI.saldo							saldo,
            		INI.costo							costo,
            		CASE WHEN TM2.sli_total IS NULL OR TM2.sli_total = 0 THEN INI.costo ELSE TM2.sli_total END sli_total,
            		INI.ppp                              ppp,
            		CMM.elegido * CMM.factor             revalorizado
            FROM	[907610004_cmm_saldosiniciales] INI LEFT OUTER JOIN #tmp_sal_compra TM2 ON INI.planta = TM2.planta AND INI.articulo = TM2.articulo
                                                        LEFT OUTER JOIN [907610004_cmm_correccionmonetaria] CMM ON INI.planta = CMM.planta AND INI.articulo = CMM.articulo AND CMM.ano = '2006'
            WHERE   INI.planta = '".$lsPlanta."' AND INI.mes = '".trim($lsAno)."01' AND INI.saldo <> 0
            ORDER	BY
            		INI.planta,
            		INI.articulo";
            $result = mssql_query($lsSQL);
            
            echo "<table>";
            echo "
            <tr height=20>
            <td><b>PLANTA</b></td>
            <td><b>ARTICULO</b></td>
            <td><b>FECHA</b></td>
            <td><b>MES</b></td>
            <td><b>SALDO</b></td>
            <td><b>COSTO UNITARIO SAP</b></td>
            <td><b>COSTO UNITARIO SLI</b></td>
            <td><b>COSTO UNITARIO PPP</b></td
            <td><b>COSTO UNITARIO REVALORIZADO</b></td
            <td><b>COSTO TOTAL SAP</b></td>
            <td><b>COSTO TOTAL SLI</b></td>
            <td><b>COSTO TOTAL PPP</b></td>
            <td><b>COSTO TOTAL REVALORIZADO</b></td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                echo "
                <tr height=20>
                <td>".trim($row["planta"])."</td>
                <td>".trim($row["articulo"])."</td>
                <td>".trim($row["fecha"])."</td>
                <td>".trim($row["mes"])."</td>
                <td>".trim($row["saldo"])."</td>
                <td>".number_format(trim($row["costo"]),0,"","")."</td>
                <td>".number_format(trim($row["sli_total"]),0,"","")."</td>
                <td>".number_format(trim($row["ppp"]),0,"","")."</td>
                <td>".number_format(trim($row["revalorizado"]),0,"","")."</td>
                <td>".number_format(trim($row["costo"]*$row["saldo"]),0,"","")."</td>
                <td>".number_format(trim($row["sli_total"]*$row["saldo"]),0,"","")."</td>
                <td>".number_format(trim($row["ppp"]*$row["saldo"]),0,"","")."</td>
                <td>".number_format(trim($row["revalorizado"]*$row["saldo"]),0,"","")."</td>
                </tr>";
            }
            echo "</table>";
            break;
            
        case 14: /* Saldos finales */
        
            $lsSQL = "
            SELECT	FIN.planta							planta,
            		FIN.articulo						articulo,
            		CONVERT(CHAR(10),FIN.docto_fec,103)	fecha,
            		FIN.mes								mes,
            		FIN.saldo							saldo,
            		CASE WHEN ISNULL(FIN.costo,0)=0 THEN CONVERT(NUMERIC(15,4),FIN.valor/FIN.saldo) ELSE FIN.costo END costo,
            		FIN.valor							valor,
            		FIN.sli_total						sli_total,
            		FIN.ppp                             ppp,
            		FIN.ppp_acumulado                   ppp_acumulado,
            		CONVERT(NUMERIC(15,0),CMM.elegido * CMM.factor) revalorizado
            FROM	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_correccionmonetaria] CMM ON FIN.planta = CMM.planta AND FIN.articulo = CMM.articulo AND CMM.ano = '".trim($lsAno)."'
            WHERE   FIN.planta = '".trim($lsPlanta)."' AND
            		FIN.mes    = '".trim($lsAno)."12' AND
            		FIN.saldo <> 0
            ORDER	BY
            		FIN.planta,
            		FIN.articulo";
            $result = mssql_query($lsSQL);
            
            echo "<table border=1>";
            echo "
            <tr height=20>
            <td align='center' bgcolor='silver'><b></b></td>
            <td align='center' bgcolor='silver'><b></b></td>
            <td align='center' bgcolor='silver'><b></b></td>
            <td align='center' bgcolor='silver'><b></b></td>
            <td align='center' bgcolor='silver'><b></b></td>
            <td align='center' bgcolor='silver' colspan=4><b>UNITARIO</b></td>
            <td align='center' bgcolor='silver' colspan=4><b>TOTAL</b></td>
            <td align='center' bgcolor='yellow' colspan=4><b>ULT. MOVIMIENTO</b></td>
            </tr>";
            echo "
            <tr height=20>
            <td align='center' bgcolor='silver'><b>PLANTA</b></td>
            <td align='center' bgcolor='silver'><b>ARTICULO</b></td>
            <td align='center' bgcolor='silver'><b>FECHA</b></td>
            <td align='center' bgcolor='silver'><b>MES</b></td>
            <td align='center' bgcolor='silver'><b>SALDO</b></td>
            <td align='center' bgcolor='silver'><b>SAP</b></td>
            <td align='center' bgcolor='silver'><b>SLI</b></td>
            <td align='center' bgcolor='silver'><b>PPP</b></td>
            <td align='center' bgcolor='silver'><b>REV</b></td>
            <td align='center' bgcolor='silver'><b>SAP</b></td>
            <td align='center' bgcolor='silver'><b>SLI</b></td>
            <td align='center' bgcolor='silver'><b>PPP</b></td>
            <td align='center' bgcolor='silver'><b>REV</b></td>
            <td align='center' bgcolor='yellow'><b>FECHA</b></td>
            <td align='center' bgcolor='yellow'><b>CODIGO</b></td>
            <td align='center' bgcolor='yellow'><b>MOVIMIENTO</b></td>
            <td align='center' bgcolor='yellow'><b>CANTIDAD</b></td>
            </tr>";
            
            while($row = mssql_fetch_array($result)){
                if(trim($row["mov_desc"])=="SALDO INICIAL"&&trim($row["cantidad"])=="0"){
                } else{
                    echo "
                    <tr height=20>
                    <td>".trim($row["planta"])."</td>
                    <td>".trim($row["articulo"])."</td>
                    <td>".trim($row["fecha"])."</td>
                    <td>".trim($row["mes"])."</td>
                    <td>".trim($row["saldo"])."</td>
                    <td>".number_format(trim($row["costo"]),0,"","")."</td>
                    <td>".number_format(trim($row["sli_total"]),0,"","")."</td>
                    <td>".number_format(trim($row["ppp"]),0,"","")."</td>
                    <td>".number_format(trim($row["revalorizado"]),0,"","")."</td>
                    <td>".number_format(trim($row["costo"]*$row["saldo"]),0,"","")."</td>
                    <td>".number_format(trim($row["sli_total"]*$row["saldo"]),0,"","")."</td>
                    <td>".number_format(trim($row["ppp_acumulado"]),0,"","")."</td>
                    <td>".number_format(trim($row["revalorizado"]*$row["saldo"]),0,"","")."</td>
                    <td>".trim($row["docto_fec"])."</td>
                    <td>".trim($row["mov_tipo"])."</td>
                    <td>".trim($row["mov_desc"])."</td>
                    <td>".trim($row["cantidad"])."</td>
                    </tr>";
                }
            }
            echo "</table>";
            break;
            
        case 15: /* Saldos iniciales (PDF) */
        
            $pdf = new PDF();
        	$pdf->FPDF('L','mm',"A4");
        	$pdf->AliasNbPages();
        	$pdf->AddPage();
        
            $lsSQL = "
            select	planta			planta,
            		articulo		articulo,
            		max(docto_fec)	docto_fec
            into	#tmp_2
            from	[907610004_cmm_libroexistencias]
            where	planta = '".trim($lsPlanta)."' AND
            		mov_tipo = '101' and
            		left(mes,4) = '2006'
            group	by
            		planta,
            		articulo
            
            select	LIB.planta		planta,
            		LIB.articulo	articulo,
            		max(LIB.id)		id
            into	#tmp_compra
            from	[907610004_cmm_libroexistencias] LIB INNER JOIN #tmp_2 TMP ON LIB.planta = TMP.planta AND LIB.articulo = TMP.articulo AND LIB.docto_fec = TMP.docto_fec
            where	LIB.planta = '".trim($lsPlanta)."' AND
            		LIB.mov_tipo = '101' and
            		left(LIB.mes,4) = '2006'
            group	by
            		LIB.planta,
            		LIB.articulo
            
            select	LIB.planta,
            		LIB.articulo,
            		LIB.costo,
            		LIB.sli_total,
            		LIB.ppp
            INTO	#tmp_sal_compra
            from	[907610004_cmm_libroexistencias] LIB INNER JOIN #tmp_compra TMP ON LIB.planta = TMP.planta AND LIB.articulo = TMP.articulo AND LIB.id = TMP.id
            where	LIB.planta = '".trim($lsPlanta)."' AND
            		LIB.mov_tipo = '101' and
            		left(LIB.mes,4) = '2006'
            
            SELECT	INI.planta							planta,
            		INI.articulo						articulo,
            		CONVERT(CHAR(10),INI.docto_fec,103)	fecha,
            		INI.mes								mes,
            		INI.saldo							saldo,
            		INI.costo							costo,
            		CASE WHEN TM2.sli_total IS NULL OR TM2.sli_total = 0 THEN INI.costo ELSE TM2.sli_total END sli_total,
            		INI.ppp                              ppp,
            		CMM.elegido * CMM.factor             revalorizado
            FROM	[907610004_cmm_saldosiniciales] INI LEFT OUTER JOIN #tmp_sal_compra TM2 ON INI.planta = TM2.planta AND INI.articulo = TM2.articulo
                                                        LEFT OUTER JOIN [907610004_cmm_correccionmonetaria] CMM ON INI.planta = CMM.planta AND INI.articulo = CMM.articulo AND CMM.ano = '2006'
            WHERE   INI.planta = '".$lsPlanta."' AND INI.mes = '".trim($lsAno)."01' AND INI.saldo <> 0
            ORDER	BY
            		INI.planta,
            		INI.articulo";
            $result = mssql_query($lsSQL);
            
            $pdf->SetFont("Times","",8);
            while($row = mssql_fetch_array($result)){
                $pdf->Cell(40,4,"","","","C");
                $pdf->Cell(12,4,trim($row["planta"]),"1","","C");
                $pdf->Cell(19,4,trim($row["articulo"]),"1","","C");
                $pdf->Cell(15,4,trim($row["fecha"]),"1","","C");
                $pdf->Cell(10,4,trim($row["mes"]),"1","","C");
                $pdf->Cell(15,4,trim($row["saldo"]),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["costo"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["sli_total"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["ppp"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["revalorizado"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["costo"]*$row["saldo"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["sli_total"]*$row["saldo"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["ppp"]*$row["saldo"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["revalorizado"]*$row["saldo"]),0),"1","","R");
                $pdf->Ln();
        	}
            $pdf->Output();            
            break;
            
        case 16: /* Saldos finales (PDF) */
        
            $pdf = new PDF();
        	$pdf->FPDF('L','mm',"A4");
        	$pdf->AliasNbPages();
        	$pdf->AddPage();
        
            $lsSQL = "
            SELECT	FIN.planta							planta,
            		FIN.articulo						articulo,
            		CONVERT(CHAR(10),FIN.docto_fec,103)	fecha,
            		FIN.mes								mes,
            		FIN.saldo							saldo,
            		CASE WHEN ISNULL(FIN.costo,0)=0 THEN CONVERT(NUMERIC(15,4),FIN.valor/FIN.saldo) ELSE FIN.costo END costo,
            		FIN.valor							valor,
            		FIN.sli_total						sli_total,
            		FIN.ppp                             ppp,
            		FIN.ppp_acumulado                   ppp_acumulado,
            		CONVERT(NUMERIC(15,0),CMM.elegido * CMM.factor) revalorizado
            FROM	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_correccionmonetaria] CMM ON FIN.planta = CMM.planta AND FIN.articulo = CMM.articulo AND CMM.ano = '".trim($lsAno)."'
            WHERE   FIN.planta = '".trim($lsPlanta)."' AND
            		FIN.mes    = '".trim($lsAno)."12' AND
            		FIN.saldo <> 0
            ORDER	BY
            		FIN.planta,
            		FIN.articulo";
            $result = mssql_query($lsSQL);
            
            $pdf->SetFont("Times","",8);
            while($row = mssql_fetch_array($result)){
                $pdf->Cell(40,4,"","","","C");
                $pdf->Cell(12,4,trim($row["planta"]),"1","","C");
                $pdf->Cell(19,4,trim($row["articulo"]),"1","","C");
                $pdf->Cell(15,4,trim($row["fecha"]),"1","","C");
                $pdf->Cell(10,4,trim($row["mes"]),"1","","C");
                $pdf->Cell(15,4,trim($row["saldo"]),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["costo"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["sli_total"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["ppp"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["revalorizado"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["costo"]*$row["saldo"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["sli_total"]*$row["saldo"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["ppp"]*$row["saldo"]),0),"1","","R");
                $pdf->Cell(15,4,number_format(trim($row["revalorizado"]*$row["saldo"]),0),"1","","R");
                $pdf->Ln();
        	}
            $pdf->Output();            
            break;
            
    }
    
?>
