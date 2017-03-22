<?

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
                                <td>&nbsp;&nbsp;<img src="images/mainlogo_full.gif" /></td>
                                <td align="right"><?include("corCabecera.php");?></td>
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
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010100.php')">&nbsp;&nbsp;&nbsp;Compras sin referencia</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010200.php')">&nbsp;&nbsp;&nbsp;Compras que no existen en SLI</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010300.php')">&nbsp;&nbsp;&nbsp;Compras sin embarque</td></tr>
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Compras sin despacho</td></tr>
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
                                                                    SELECT  LIB.planta,
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
                                                                    FROM    [907610004_cmm_libroexistencias] LIB INNER JOIN  CLIENTES..Factura_Enc FAC ON RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(LIB.referencia)),20) = RIGHT(REPLICATE('0',20) + RTRIM(LTRIM(FAC.num_facturaproveedor)),20) AND LIB.cod_proveedor = FAC.id_proveedor
                                                                                                             LEFT OUTER JOIN SLI..apertura         APE ON FAC.id_cliente = APE.id_cliente AND FAC.num_embarque = APE.ref_cliente AND YEAR(APE.fechaape) >= 2006 AND APE.id_cliente = '907610004'
                                                                    WHERE   CONVERT(INT,FAC.num_embarque) > 30000 AND
                                                                            LIB.mov_tipo = '101' AND
                                                                            LEFT(LIB.mes,4) = '".trim($lsAno)."' AND
                                                                            FAC.num_embarque IS NOT NULL AND
                                                                            APE.ref_cliente IS NULL AND
                                                                            LIB.proveedor NOT IN (SELECT proveedor FROM DOCUMENTOS..proveedor_nacional)
                                                                    GROUP	BY
                                                                    		LIB.planta
                                                                    ORDER   BY
                                                                            LIB.planta";
                                                                    $result = mssql_query($lsSQL);
                                                                    
                                                                    $liCount = 1;
                                                                    while($row = mssql_fetch_array($result)){
                                                                        
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
                                                                        <td style='width:22px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center'><a href='cor010000.php?TIP=9&PLA=".trim($row["planta"])."' target='_blank'><img border=0 src='images/excel.jpg'></a></td>
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
                            <tr><td><img src="images/body_bottomwrapper_bg.gif" /></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
