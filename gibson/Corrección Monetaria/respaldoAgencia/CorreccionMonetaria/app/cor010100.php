<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    //$lsAno = $HTTP_GET_VARS["ANO"];
    
?>
<html>
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <form id="form1" runat="server">
            <table cellpadding="0" cellspacing="0" width="100%" height="100%" border=0>
                <tr height="70">
                    <td align="center">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>&nbsp;&nbsp;<img src="images/mainlogo_full2.gif" /></td>
                                <td align="right"><?php include("corCabecera.php");?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="height:10px"><td></td></tr>
                <tr>
                    <td align="center">
                        <table cellpadding="0" cellspacing="0" width="986">
                            <tr height="500">
                                <td background="images/body_innerwrapper_bg.jpg" valign="top" align="Center">
                                    <table width=950 align="center" cellpadding="0" cellspacing="0">
                                        <tr height="35"><td colspan="2" align="right" style="color:#005aff;font:bold bold 13pt tahoma"><b>Inconsistencias <?=$lsAno?></b>&nbsp;&nbsp;</td></tr>
                                        <tr>
                                            <td align="left" width="200" valign="top">
                                                <table cellpadding="0" cellspacing="0" height="455">
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:1px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Compras sin referencia</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010200.php')">&nbsp;&nbsp;&nbsp;Compras que no existen en SLI</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010300.php')">&nbsp;&nbsp;&nbsp;Compras sin embarque</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010400.php')">&nbsp;&nbsp;&nbsp;Compras sin despacho</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010500.php')">&nbsp;&nbsp;&nbsp;Facturas en tránsito SLI (PM)</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010600.php')">&nbsp;&nbsp;&nbsp;Embarques sin factura SLI (PM)</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010700.php')">&nbsp;&nbsp;&nbsp;Facturas sin fecha</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010800.php')">&nbsp;&nbsp;&nbsp;Facturas sin moneda</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010900.php')">&nbsp;&nbsp;&nbsp;Facturas sin embarque</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor011000.php')">&nbsp;&nbsp;&nbsp;Facturas sin O/C</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor011100.php')">&nbsp;&nbsp;&nbsp;Despachos sin factura</td></tr>
                                                    <tr><td height="100" align="center" valign="top" style="border-right:1px solid silver"><img src="images/borderbox_bottom.jpg" /></td></tr>
                                                </table>
                                            </td>
                                            <td align="left" valign="top">
                                                <table cellpadding="0" cellspacing="0" width="745" height="455">
                                                    <tr>
                                                        <td style="border-top:1px solid silver;border-right:1px solid silver;border-bottom:1px solid silver" align="center">
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
                                                                    FROM    [907610004_cmm_libroexistencias]
                                                                    WHERE   mov_tipo = '101' AND
                                                                            LEFT(mes,4) = '".trim($lsAno)."' AND
                                                                            (referencia IS NULL OR RTRIM(LTRIM(referencia)) = '') AND
                                                                            proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
                                                                    GROUP	BY
                                                                    		planta
                                                                    ORDER   BY
                                                                            planta";
                                                                    $result = mssql_query($lsSQL);
                                                                    
                                                                    $liCount = 1;
                                                                    while($row = mssql_fetch_array($result)){
                                                                        
                                                                        $lsSQL = "
                                                                        SELECT  planta,
                                                                                articulo,
                                                                                docto_num,
                                                                                po,
                                                                                convert(char(10),docto_fec,103) fecha,
                                                                                cantidad,
                                                                                costo,
                                                                                valor,
                                                                                cod_proveedor,
                                                                                proveedor,
                                                                                referencia
                                                                        FROM    [907610004_cmm_libroexistencias]
                                                                        WHERE   mov_tipo = '101' AND
                                                                                LEFT(mes,4) = '".trim($lsAno)."' AND
                                                                                (referencia IS NULL OR RTRIM(LTRIM(referencia)) = '') AND
                                                                                planta = '".trim($row["planta"])."' AND
                                                                                proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
                                                                        ORDER   BY
                                                                                planta,
                                                                                articulo";
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
                                                                            </tr>";
                                                                            fwrite($handle,$lsHTML);
                                                                        }
                                                                        
                                                                        fwrite($handle,"</table>");
                                                                        fclose($handle);
                                                                        
                                                                        echo "
                                                                        <tr height=23>
                                                                        <td style='width:30px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:1px solid silver' align='right' bgcolor='#ededed'>&nbsp;<b>".trim($liCount)."</b>&nbsp;</td>
                                                                        <td style='width:50px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='left'>&nbsp;".trim($row["planta"])."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["ENE"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["FEB"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["MAR"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["ABR"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["MAY"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["JUN"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["JUL"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["AGO"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["SEP"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["OCT"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["NOV"]),0)."&nbsp;</td>
                                                                        <td style='width:35px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["DIC"]),0)."&nbsp;</td>
                                                                        <td style='width:40px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;<b>".number_format(trim($row["TOT"]),0)."</b>&nbsp;</td>
                                                                        <td style='width:22px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center'><img src='images/excel.jpg' style='cursor:hand' onclick='window.open(".chr(34).$lsArchivo.chr(34).")'></td>
                                                                        </tr>";
                                                                        $liCount++;
                                                                        
                                                                    }
                                                                    
                                                                ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td><img src="./images/body_bottomwrapper_bg.gif" /></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
