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
    <head>
        <script language="JavaScript" type="text/JavaScript" src="funciones.js"></script>
        <script>
            
            var giPR;
            var giTR;
            var giTD;
            var giXX;
            
            function ProcesaDatos(iDato){
                
                giTR     = document.all("tabPlantas").getElementsByTagName("tr");
                laPlanta = giTR[iDato].getElementsByTagName("td")[1].innerHTML.split("&nbsp;")
                lsURL    = "cor040400_dat.php?ANO=<?=trim($lsAno)?>&PLA=" + laPlanta[1];
                giTD     = giTR[iDato].getElementsByTagName("td")[2];
                giXX     = iDato + 1;
                
                giTD.innerHTML = "<img src='images/loading.gif' height=20>";
                GeneraObjeto("MuestraPlanta",lsURL);
                
            }
            
            function MuestraPlanta(){
                if((xmlhttp.readyState==4)){
                    lsDatos = xmlhttp.responseText;
                    giTD.innerHTML = "<img src='images/excel.jpg'>";
                    if(giTR.length-1>giXX){
                        ProcesaDatos(giXX);
                    } else{
                        if(giPR<6){
                            giPR++;
                            giXX = 1;
                            ProcesaDatos(giXX);
                        }
                    }
                }
            }
            
        </script>
    </head>
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
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor040200.php')">&nbsp;&nbsp;&nbsp;Saldos iniciales</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor040300.php')">&nbsp;&nbsp;&nbsp;Saldos finales</td></tr>
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Correcci&oacute;n monetaria</td></tr>
                                                    <tr><td height="200" align="center" valign="top" style="border-right:1px solid silver"><img src="images/borderbox_bottom.jpg" /></td></tr>
                                                </table>
                                            </td>
                                            <td align="left" valign="top">
                                                <table cellpadding="0" cellspacing="0" width="745" height="455">
                                                    <tr>
                                                        <td style="border-top:1px solid silver;border-right:1px solid silver;border-bottom:1px solid silver" align="center">
                                                            <table cellpadding="0" cellspacing="0" name="tabPlantas" id="tabPlantas">
                                                                <tr height=20 bgcolor='#8cb6ff'>
                                                                    <td style='width:30px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:1px solid silver' align='center'>&nbsp;<b>#</b>&nbsp;</td>
                                                                    <td style='width:50px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>PLANTA</b>&nbsp;</td>
                                                                    <td style='width:70px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>ARCHIVOS</b>&nbsp;</td>
                                                                </tr>
                                                                <?php
                                                                    $lsSQL = "
                                                                    SELECT	DISTINCT
                                                                            LIB.planta,
                                                                            MAX(CASE WHEN COR.articulo IS NULL THEN '' ELSE '<img border=0 src=' + char(34) + 'images/excel.jpg' + char(34) + '>' END) correccion_1,
                                                                            MAX(CASE WHEN COR.articulo IS NULL THEN '' ELSE '<img border=0 src=' + char(34) + 'images/pdf.jpg' + char(34) + '>' END) correccion_2
                                                                    FROM	[907610004_cmm_libroexistencias] LIB LEFT OUTER JOIN [907610004_cmm_correccionmonetaria] COR ON LIB.planta = COR.planta AND LIB.articulo = COR.articulo
                                                                    GROUP	BY
                                                                    		LIB.planta
                                                                    ORDER	BY
                                                                    		LIB.planta";
                                                                    $result = mssql_query($lsSQL);
                                                                    
                                                                    $liCount = 1;
                                                                    while($row = mssql_fetch_array($result)){
                                                                        
                                                                        echo "
                                                                        <tr height=23>
                                                                        <td style='width:30px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:1px solid silver' align='right' bgcolor='#ededed'>&nbsp;<b>".trim($liCount)."</b>&nbsp;</td>
                                                                        <td style='width:50px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='left'>&nbsp;".trim($row["planta"])."&nbsp;</td>
                                                                        <td style='width:70px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center'>".iif(trim($row["correccion_1"])=="","&nbsp;","<a href='Correccion_".trim($lsAno)."_".trim($row["planta"])."_xls.zip' target='_blank'>".trim($row["correccion_1"])."</a><a href='Correccion_".trim($lsAno)."_".trim($row["planta"])."_pdf.zip' target='_blank'>".trim($row["correccion_2"])."</a>")."</td>
                                                                        </tr>";
                                                                        $liCount++;
                                                                        
                                                                    }
                                                                    
                                                                    function iif($iOpc,$iVer,$iFal){
                                                                        if($iOpc){
                                                                            return $iVer;
                                                                        } else{
                                                                            return $iFal;
                                                                        }
                                                                    }
                                                                    
                                                                ?>
                                                                <tr><td colspan=3 align="right"><input type="button" value="Procesar" style="margin-top:2px;font:normal normal 8pt tahoma;border:1px solid silver;width:100px;height:20px" onclick="ProcesaDatos(1)"></td></tr>
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
