<?php

    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: application/vnd.ms-excel");
    
    include("seguridad.php");
    
    //$lsAno = $HTTP_GET_VARS["ANO"];
    
?>
<table cellpadding="0" cellspacing="0">
    <tr height=20 bgcolor='#8cb6ff'>
        <td style='width:30px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:1px solid silver' align='center'>&nbsp;<b>#</b>&nbsp;</td>
        <td style='width:50px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>PLANTA</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>ENE</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>FEB</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>MAR</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>ABR</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>MAY</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>JUN</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>JUL</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>AGO</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>SEP</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>OCT</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>NOV</b>&nbsp;</td>
        <td style='width:35px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>DIC</b>&nbsp;</td>
        <td style='width:62px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center' colspan=2>&nbsp;<b>TOTAL</b>&nbsp;</td>
    </tr>
    <?php
        
        $lsSQL = "
        SELECT  planta,
                sum(case when mes = '".trim($lsAno)."01' then 1 else 0 end) 'ENE',
        		sum(case when mes = '".trim($lsAno)."02' then 1 else 0 end) 'FEB',
        		sum(case when mes = '".trim($lsAno)."03' then 1 else 0 end) 'MAR',
        		sum(case when mes = '".trim($lsAno)."04' then 1 else 0 end) 'ABR',
                sum(case when mes = '".trim($lsAno)."05' then 1 else 0 end) 'MAY',
        		sum(case when mes = '".trim($lsAno)."06' then 1 else 0 end) 'JUN',
        		sum(case when mes = '".trim($lsAno)."07' then 1 else 0 end) 'JUL',
        		sum(case when mes = '".trim($lsAno)."08' then 1 else 0 end) 'AGO',
                sum(case when mes = '".trim($lsAno)."09' then 1 else 0 end) 'SEP',
        		sum(case when mes = '".trim($lsAno)."10' then 1 else 0 end) 'OCT',
        		sum(case when mes = '".trim($lsAno)."11' then 1 else 0 end) 'NOV',
        		sum(case when mes = '".trim($lsAno)."12' then 1 else 0 end) 'DIC',
        		count(1)                                        'TOT'
        FROM    [907610004_cmm_libroexistencias] LIB LEFT OUTER JOIN CLIENTES..Factura_Enc FAC ON RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(LIB.referencia)),20) = RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(FAC.num_facturaproveedor)),20) AND LIB.cod_proveedor = FAC.id_proveedor AND FAC.id_cliente = '907610004'
        WHERE   LIB.mov_tipo = '101' AND
                FAC.num_facturaproveedor IS NULL AND
                LIB.proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
        GROUP	BY
        		LIB.planta
        ORDER   BY
                LIB.planta";
        $result = mssql_query($lsSQL);
        
        $liCount = 1;
        while($row = mssql_fetch_array($result)){
            
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
            WHERE   LIB.mov_tipo = '101' AND
                    FAC.num_facturaproveedor IS NULL AND
                    LIB.planta = '".trim($row["planta"])."' AND
                    LIB.proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
            ORDER   BY
                    LIB.planta,
                    LIB.articulo";
            $result2 = mssql_query($lsSQL);
            
            $lsArchivo = "inconsistencias_01_".trim($row["planta"]).".xls";
            $handle    = fopen($lsArchivo,"w");
            fwrite($handle,"<table>");
            
            $lsHTML = "
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
            fwrite($handle,$lsHTML);
            
            while($row2 = mssql_fetch_array($result2)){
                $lsHTML = "
                <tr height=20>
                <td>".trim($row2["planta"])."</td>
                <td>".trim($row2["articulo"])."</td>
                <td>".trim($row2["docto_num"])."</td>
                <td>".trim($row2["po"])."</td>
                <td>".trim($row2["fecha"])."</td>
                <td>".trim($row2["cod_proveedor"])."</td>
                <td>".strtoupper(trim($row2["proveedor"]))."</td>
                <td>".number_format(trim($row2["cantidad"]),0)."</td>
                <td>".number_format(trim($row2["costo"]),0)."</td>
                <td>".number_format(trim($row2["valor"]),0)."</td>
                <td>".trim($row2["referencia"])."</td>
                <td>".trim($row2["descripcion"])."</td>
                </tr>";
                fwrite($handle,$lsHTML);
            }
            
            fwrite($handle,"</table>");
            fclose($handle);
            
            echo "
            <tr height=23>
            <td style='width:30px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:1px solid silver' align='right' bgcolor='#ededed'>&nbsp;<b>".trim($liCount)."</b>&nbsp;</td>
            <td style='width:50px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='left'>&nbsp;".trim($row["planta"])."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."01".chr(34).")'>&nbsp;".number_format(trim($row["ENE"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."02".chr(34).")'>&nbsp;".number_format(trim($row["FEB"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."03".chr(34).")'>&nbsp;".number_format(trim($row["MAR"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."04".chr(34).")'>&nbsp;".number_format(trim($row["ABR"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."05".chr(34).")'>&nbsp;".number_format(trim($row["MAY"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."06".chr(34).")'>&nbsp;".number_format(trim($row["JUN"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."07".chr(34).")'>&nbsp;".number_format(trim($row["JUL"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."08".chr(34).")'>&nbsp;".number_format(trim($row["AGO"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."09".chr(34).")'>&nbsp;".number_format(trim($row["SEP"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."10".chr(34).")'>&nbsp;".number_format(trim($row["OCT"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."11".chr(34).")'>&nbsp;".number_format(trim($row["NOV"]),0)."&nbsp;</td>
            <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right' style='cursor:hand' onclick='MuestraDetalle(".chr(34).trim($row["planta"]).chr(34).",".chr(34).trim($lsAno)."12".chr(34).")'>&nbsp;".number_format(trim($row["DIC"]),0)."&nbsp;</td>
            <td style='width:40px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;<b>".number_format(trim($row["TOT"]),0)."</b>&nbsp;</td>
            <td style='width:22px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center'><img src='images/excel.jpg' style='cursor:hand' onclick='window.open(".chr(34).$lsArchivo.chr(34).")'></td>
            </tr>";
            $liCount++;
            
        }
        
    ?>
</table>
