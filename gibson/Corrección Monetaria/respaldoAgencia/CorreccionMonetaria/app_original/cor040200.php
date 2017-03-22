<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    //$lsAno = $HTTP_GET_VARS["ANO"];
    
?>
<html>
    <?include("seguridad.php");?>
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
                                        <tr height="35"><td colspan="2" align="right" style="color:#005aff;font:bold bold 13pt tahoma"><b>Correcci&oacute;n <?=$lsAno?></b>&nbsp;&nbsp;</td></tr>
                                        <tr>
                                            <td align="left" width="200" valign="top">
                                                <table cellpadding="0" cellspacing="0" height="455">
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor040100.php')">&nbsp;&nbsp;&nbsp;Variaci&oacute;n porcentual</td></tr>
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Saldos iniciales</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor040300.php')">&nbsp;&nbsp;&nbsp;Saldos finales</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor040400.php')">&nbsp;&nbsp;&nbsp;Correcci&oacute;n monetaria</td></tr>
                                                    <tr><td height="200" align="center" valign="top" style="border-right:1px solid silver"><img src="images/borderbox_bottom.jpg" /></td></tr>
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
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>SALDO</b>&nbsp;</td>
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>SAP</b>&nbsp;</td>
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>SLI</b>&nbsp;</td>
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>PPP</b>&nbsp;</td>
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>REV</b>&nbsp;</td>
                                                                    <td style='width:70px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center'>&nbsp;<b>ARCHIVO</b>&nbsp;</td>
                                                                </tr>
                                                                <?php
                                                                    $lsSQL = "
                                                                    SELECT	INI.planta,
                                                                            SUM(INI.saldo) saldo,
                                                                            SUM(INI.valor) sap,
                                                                            SUM(FIN.sli_total*INI.saldo) sli,
                                                                            SUM(INI.ppp*INI.saldo) ppp,
                                                                            ISNULL(CONVERT(NUMERIC(15,0),SUM(CMM.elegido*CMM.factor*INI.saldo)),0) rev
                                                                    FROM	PERSONALIZADOS..[907610004_cmm_saldosiniciales] INI LEFT OUTER JOIN PERSONALIZADOS..[907610004_cmm_correccionmonetaria] CMM ON INI.planta = CMM.planta AND INI.articulo = CMM.articulo AND CMM.ano = '2006'
                                                                    		                                                    LEFT OUTER JOIN PERSONALIZADOS..[907610004_cmm_saldosfinales]       FIN ON INI.planta = FIN.planta AND INI.articulo = FIN.articulo AND FIN.mes = '200612'
                                                                    WHERE	INI.mes = '".trim($lsAno)."01' AND
                                                                            ISNULL(INI.saldo,0) <> 0
                                                                    GROUP	BY
                                                                    		INI.planta
                                                                    ORDER	BY
                                                                    		INI.planta";
                                                                    $result = mssql_query($lsSQL);
                                                                    
                                                                    $liCount = 1;
                                                                    while($row = mssql_fetch_array($result)){
                                                                        
                                                                        echo "
                                                                        <tr height=23>
                                                                        <td style='width:30px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:1px solid silver' align='right' bgcolor='#ededed'>&nbsp;<b>".trim($liCount)."</b>&nbsp;</td>
                                                                        <td style='width:50px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='left'>&nbsp;".trim($row["planta"])."&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["saldo"],0)."&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["sap"],0)."&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["sli"],0)."&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["ppp"],0)."&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["rev"],0)."&nbsp;</td>
                                                                        <td style='width:70px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center'><a href='cor010000.php?TIP=13&PLA=".trim($row["planta"])."' target='_blank'><img border=0 src='images/excel.jpg'></a><a href='cor010000.php?TIP=15&PLA=".trim($row["planta"])."' target='_blank'><img border=0 src='images/pdf.jpg'></a></td>
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
