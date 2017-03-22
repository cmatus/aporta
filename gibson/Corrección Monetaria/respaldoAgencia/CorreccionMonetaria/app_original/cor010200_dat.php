<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    
    $lsTipo = $HTTP_GET_VARS["TIP"];
    switch(trim($lsTipo)){
        
        case "1":
            
            $lsPar  = $HTTP_GET_VARS["PAR"];
            $laDato = split("///@@///",$lsPar);
            
            for($x=0;$x<count($laDato);$x++){
                $laVal = split("@@@",$laDato[$x]);
                $lsSQL = "UPDATE [907610004_cmm_libroexistencias] SET cod_proveedor = '".trim($laVal[1])."', referencia = '".trim($laVal[2])."' WHERE id = ".trim($laVal[0]);
                mssql_query($lsSQL);
            }
            
            $lsSQL = "
            SELECT  LIB.ID,
                    LIB.planta,
                    LIB.articulo,
                    LIB.docto_num,
                    LIB.po,
                    convert(char(10),LIB.docto_fec,103) fecha,
                    LIB.cantidad,
                    LIB.costo,
                    LIB.valor,
                    LIB.cod_proveedor,
                    LIB.proveedor,
                    LIB.referencia
            FROM    [907610004_cmm_libroexistencias] LIB LEFT OUTER JOIN CLIENTES..Factura_Enc FAC ON RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(LIB.referencia)),20) = RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(FAC.num_facturaproveedor)),20) AND LIB.cod_proveedor = FAC.id_proveedor AND FAC.id_cliente = '907610004'
            WHERE   LIB.mov_tipo = '101' AND
                    FAC.num_facturaproveedor IS NULL AND
                    LIB.planta = '".trim($lsPlanta)."' AND
            		LIB.mes = '".trim($lsMes)."' AND
                    LIB.proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
            ORDER   BY
                    LIB.articulo";
            $result = mssql_query($lsSQL);
            
            $liCount = 1;
            
            echo "<table cellpadding=0 cellspacing=0 name='tabDetalle' id='tabDetalle'>";
            while($row = mssql_fetch_array($result)){
                echo "
                <tr name='tr_".trim($row["ID"])."'>
                <td align='right'  width=30  class='GridDet_0' align='right' bgcolor='#ededed'>&nbsp;<b>".trim($liCount)."</b>&nbsp;</td>
                <td align='right'  width=80  class='GridDet_1' bgcolor='white'>&nbsp;".trim($row["articulo"])."&nbsp;</td>
                <td align='right'  width=65  class='GridDet_1' bgcolor='white'>&nbsp;".trim($row["docto_num"])."&nbsp;</td>
                <td align='right'  width=65  class='GridDet_1' bgcolor='white'>&nbsp;".trim($row["po"])."&nbsp;</td>
                <td align='center' width=70  class='GridDet_1' bgcolor='white'>&nbsp;".trim($row["fecha"])."&nbsp;</td>
                <td align='right'  width=60  class='GridDet_1' bgcolor='white'>&nbsp;".number_format(trim($row["cantidad"]),0)."&nbsp;</td>
                <td align='right'  width=60  class='GridDet_1' bgcolor='white'>&nbsp;".number_format(trim($row["costo"]),0)."&nbsp;</td>
                <td align='right'  width=60  class='GridDet_1' bgcolor='white'>&nbsp;".number_format(trim($row["valor"]),0)."&nbsp;</td>
                <td align='right'  width=45  class='GridDet_1' bgcolor='lightyellow'>&nbsp;<input type='hidden' name='pro_hdn_".trim($row["ID"])."' value='".trim($row["cod_proveedor"])."'><input type='text' name='pro_".trim($row["ID"])."' class='GridTexto' style='text-align:right;width:35px' value='".trim($row["cod_proveedor"])."'>&nbsp;</td>
                <td align='left'   width=200 class='GridDet_1' bgcolor='white'>&nbsp;".trim($row["proveedor"])."&nbsp;</td>
                <td align='right'  width=69  class='GridDet_1' bgcolor='lightyellow'>&nbsp;<input type='hidden' name='ref_hdn_".trim($row["ID"])."' value='".trim($row["referencia"])."'><input type='text' name='ref_".trim($row["ID"])."' class='GridTexto' style='text-align:right;width:60px' value='".trim($row["referencia"])."'>&nbsp;</td>
                </tr>";
                $liCount++;
            }
            echo "</table>";
            break;
            
    }
    
?>
