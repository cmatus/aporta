<?php

    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");

    include("seguridad.php");
    
    $lsTipo = $HTTP_GET_VARS["TIP"];
    if(trim($lsTipo)=="1"){
            
        $lsSQL = "
        SELECT  ano
        FROM    [907610004_cmm_parametros]
        WHERE   estado = 1";
        $result = mssql_query($lsSQL);
    
        if($row = mssql_fetch_array($result)){
            $lsSQL = "sp907610004_cmm_InicializaAno @ano = '".($row["ano"]+1)."'";
            mssql_query($lsSQL);
        }
        
    }
    
    $lsSQL = "
    SELECT  ano
    FROM    [907610004_cmm_parametros]
    WHERE   estado = 1";
    $result = mssql_query($lsSQL);

    if($row = mssql_fetch_array($result)){
        $lsAno = $row["ano"];
    }
    
?>
<html>
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <div name="divMaestro" id="divMaestro" style="border:1px solid silver;position:absolute;visibility:hidden;z-index:1">&nbsp;</div>
        <form name="thisform" action="cor020500.php?TIP=1" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" height="100%" border=0 name="tabVentana" id="tabVentana">
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
                                        <tr height="35"><td colspan="2" align="right" style="color:#005aff;font:bold bold 13pt tahoma"><b>Existencias <?=$lsAno?></b>&nbsp;&nbsp;</td></tr>
                                        <tr>
                                            <td align="left" width="200" valign="top">
                                                <table cellpadding="0" cellspacing="0" height="455">
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor020100.php')">&nbsp;&nbsp;&nbsp;Carga archivo texto</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor020200.php')">&nbsp;&nbsp;&nbsp;Carga planilla Excel</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor020300.php')">&nbsp;&nbsp;&nbsp;Libro de existencias</td></tr>
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Cambio de año</td></tr>
                                                    <tr><td height="221" align="center" valign="top" style="border-right:1px solid silver"><img src="images/borderbox_bottom.jpg" /></td></tr>
                                                </table>
                                            </td>
                                            <td align="left" valign="top">
                                                <table cellpadding="0" cellspacing="0" width="745" height="455">
                                                    <tr>
                                                        <td style="border-top:1px solid silver;border-right:1px solid silver;border-bottom:1px solid silver" align="center">
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td>
                                                                        <table cellpadding="0" cellspacing="0">
                                                                            <tr height=30>
                                                                                <td bgcolor='silver' style="border:1px solid silver;font:normal normal 8pt tahoma">&nbsp;<b>Año actual</b>&nbsp;</td>
                                                                                <td style="border:1px solid silver;border-left:0px;font:normal normal 8pt tahoma">&nbsp;<b><?=$lsAno?></b>&nbsp;</td>
                                                                                <td style="border:1px solid silver;border-left:0px;font:normal normal 8pt tahoma">&nbsp;<input type="submit" value="Cambiar año">&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
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
    <div style="z-index:3;position:absolute;top:100px;visibility:hidden" name="divProcesar" id="divProcesar"></div>
</html>
