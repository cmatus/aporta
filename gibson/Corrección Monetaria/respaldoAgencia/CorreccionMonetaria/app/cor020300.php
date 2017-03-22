<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");  
    include("seguridad.php");
?>
<html>
    <head>
        <script language="JavaScript" type="text/JavaScript" src="http://www.stein.cl/SLI/Include/funciones.js"></script>
        <script>
            
            function ProcesaDatos(){
                document.all("divProcesar").innerHTML = "<iframe src='cor020300_det.php' frameborder='0' scrolling='no' style='margin-left:0px;width:360px;height:300px'></iframe>";
                document.all("divProcesar").style.visibility = "visible";
                UbicaObjeto(document.all("divProcesar"),document.all("tabVentana"),1);
            }
            
            function CambiaMes(){
                if((xmlhttp.readyState==4)){
                    var lsAno = document.all("cmbAno").value;
                    document.all("tdMes").innerHTML = "&nbsp;<select name='cmbMes' id='cmbMes' style='font:normal normal 8pt tahoma;width:120px' onchange='GeneraObjeto(\"CambiaPlanta\",\"cor020300_dat.php?TIP=11&ANO=" + lsAno + "&MES=\" + this.value)'>" + "<option value=''>:: MES ::</option>" + xmlhttp.responseText + "</select>&nbsp;";
                }
            }
            
            function CambiaPlanta(){
                if((xmlhttp.readyState==4)){
                    document.all("tdPlanta").innerHTML = "&nbsp;<select style='font:normal normal 8pt tahoma;width:85px' name='cmbPlanta' id='cmbPlanta'>" + "<option value=''>:: PLANTA ::</option>" + xmlhttp.responseText + "</select>&nbsp;";
                }
            }
            
            var imgExcel;
            var imgPDF;
            
            function VerExcel(iImagen){
                imgExcel = iImagen
                if(document.all("cmbAno").value==""){
                    alert("Debe seleccionar el año");
                } else{
                    if(document.all("cmbMes").value==""){
                        alert("Debe seleccionar el mes");
                    } else{
                        if(document.all("cmbPlanta").value==""){
                            alert("Debe seleccionar la planta");
                        } else{
                            //iImagen.src = "images/loading.gif"
                            //iImagen.style.height = "18px";
                            //GeneraObjeto("MuestraExcel","cor020300_dat.php?TIP=12&MES=" + document.all("cmbAno").value + document.all("cmbMes").value + "&PLA=" + document.all("cmbPlanta").value);
                            window.open("LibroExistencias_" + document.all("cmbAno").value + document.all("cmbMes").value + "_" + document.all("cmbPlanta").value + "_xls.zip")
                        }
                    }
                }
            }
            
            function MuestraExcel(){
                if((xmlhttp.readyState==4)){
                    imgExcel.src = "images/excel.jpg";
                    imgExcel.onclick = function(){window.open(xmlhttp.responseText)};
                }
            }
            
            function VerPDF(iImagen){
                imgPDF = iImagen
                if(document.all("cmbAno").value==""){
                    alert("Debe seleccionar el año");
                } else{
                    if(document.all("cmbMes").value==""){
                        alert("Debe seleccionar el mes");
                    } else{
                        if(document.all("cmbPlanta").value==""){
                            alert("Debe seleccionar la planta");
                        } else{
                            //iImagen.src = "images/loading.gif"
                            //iImagen.style.height = "18px";
                            //GeneraObjeto("MuestraPDF","cor020300_dat.php?TIP=13&MES=" + document.all("cmbAno").value + document.all("cmbMes").value + "&PLA=" + document.all("cmbPlanta").value);
                            window.open("LibroExistencias_" + document.all("cmbAno").value + document.all("cmbMes").value + "_" + document.all("cmbPlanta").value + "_pdf.zip")
                        }
                    }
                }
            }
            
            function MuestraPDF(){
                if((xmlhttp.readyState==4)){
                    imgPDF.src = "images/pdf.jpg";
                    imgPDF.onclick = function(){window.open(xmlhttp.responseText)};
                }
            }
            
        </script>
    </head>
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <div name="divMaestro" id="divMaestro" style="border:1px solid silver;position:absolute;visibility:hidden;z-index:1">&nbsp;</div>
        <form name="thisform" action="cor020300.php" method="post">
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
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onMouseOver="this.style.font='bold bold 8pt tahoma'" onMouseOut="this.style.font='normal normal 8pt tahoma'" nowrap onClick="document.location.replace('cor020100.php')">&nbsp;&nbsp;&nbsp;Carga archivo texto</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onMouseOver="this.style.font='bold bold 8pt tahoma'" onMouseOut="this.style.font='normal normal 8pt tahoma'" nowrap onClick="document.location.replace('cor020200.php')">&nbsp;&nbsp;&nbsp;Carga planilla Excel</td></tr>
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Libro de existencias</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onMouseOver="this.style.font='bold bold 8pt tahoma'" onMouseOut="this.style.font='normal normal 8pt tahoma'" nowrap onClick="document.location.replace('cor020500.php')">&nbsp;&nbsp;&nbsp;Cambio de año</td></tr>
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
                                                                            <tr height=20 bgcolor='#8cb6ff'>
                                                                                <td style='width:30px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:1px solid silver' align='center'>&nbsp;<b>#</b>&nbsp;</td>
                                                                                <td style='width:50px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>PLANTA</b>&nbsp;</td>
                                                                                <td style='width:75px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>SALDO</b>&nbsp;</td>
                                                                                <td style='width:75px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>SAP</b>&nbsp;</td>
                                                                                <td style='width:75px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>SLI</b>&nbsp;</td>
                                                                                <td style='width:75px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>PPP</b>&nbsp;</td>
                                                                                <td style='width:75px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>REV</b>&nbsp;</td>
                                                                            </tr>
                                                                            <?php
                                                                                
                                                                                $lsSQL = "
                                                                                SELECT	FIN.planta,
                                                                                        SUM(FIN.saldo) saldo,
                                                                                        SUM(FIN.valor) sap,
                                                                                        SUM(FIN.sli_total*FIN.saldo) sli,
                                                                                        SUM(FIN.ppp_acumulado) ppp,
                                                                                        CONVERT(NUMERIC(15,0),SUM(CMM.elegido*CMM.factor*CMM.saldo)) rev
                                                                                FROM	PERSONALIZADOS..[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN PERSONALIZADOS..[907610004_cmm_correccionmonetaria] CMM ON FIN.planta = CMM.planta AND FIN.articulo = CMM.articulo AND CMM.ano = '".trim($lsAno)."'
                                                                                WHERE	FIN.mes = '".trim($lsAno)."12' AND
                                                                                        ISNULL(FIN.saldo,0) <> 0
                                                                                GROUP	BY
                                                                                		FIN.planta
                                                                                ORDER	BY
                                                                                		FIN.planta";
                                                                                $result = mssql_query($lsSQL);
                                                                                
                                                                                $liCount = 1;
                                                                                while($row = mssql_fetch_array($result)){
                                                                                    
                                                                                    echo "
                                                                                    <tr height=30 style='cursor:hand' onmouseover='this.style.backgroundColor=".chr(34)."#ededed".chr(34)."' onmouseout='this.style.backgroundColor=".chr(34)."white".chr(34)."'>
                                                                                    <td style='width:30px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:1px solid silver' align='right' bgcolor='#ededed'>&nbsp;<b>".trim($liCount)."</b>&nbsp;</td>
                                                                                    <td style='width:50px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='left'>&nbsp;".trim($row["planta"])."&nbsp;</td>
                                                                                    <td style='width:75px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["saldo"],0)."&nbsp;</td>
                                                                                    <td style='width:75px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["sap"],0)."&nbsp;</td>
                                                                                    <td style='width:75px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["sli"],0)."&nbsp;</td>
                                                                                    <td style='width:75px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["ppp"],0)."&nbsp;</td>
                                                                                    <td style='width:75px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format($row["rev"],0)."&nbsp;</td>
                                                                                    </tr>";
                                                                                    $liCount++;
                                                                                    
                                                                                }
                                                                                
                                                                            ?>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr><td align="right"><input type="button" value="Procesar" onClick="ProcesaDatos()" style="margin-top:2px;font:normal normal 8pt tahoma;border:1px solid silver;width:120px;height:20px"></td></tr>
                                                                <tr height="50px">
                                                                    <td align="center">
                                                                        <table cellpadding=0 cellspacing=0 style="border:1px solid silver;width:100%;height:40px">
                                                                            <tr>
                                                                                <td style="font:bold bold 8pt tahoma;text-align:right">&nbsp;&nbsp;Año&nbsp;</td>
                                                                                <td>&nbsp;<select style="font:normal normal 8pt tahoma;width:70px" name="cmbAno" id="cmbAno" onChange="GeneraObjeto('CambiaMes','cor020300_dat.php?TIP=10&ANO=' + this.value)">
                                                                                <?php
                                                                                    $lsSQL = "SELECT DISTINCT LEFT(mes,4) ano FROM PERSONALIZADOS..[907610004_cmm_saldosfinales] ORDER BY LEFT(mes,4) DESC";
                                                                                    $result = mssql_query($lsSQL);
                                                                                    echo "<option value=''>:: AÑO ::</option>";
                                                                                    while($row = mssql_fetch_array($result)){
                                                                                        echo "<option value='".trim($row["ano"])."'>".trim($row["ano"])."</option>";
                                                                                    }
                                                                                ?>
                                                                                &nbsp;</td>
                                                                                <td style="font:bold bold 8pt tahoma;text-align:right">&nbsp;Mes&nbsp;</td><td name="tdMes" id="tdMes">&nbsp;<select name="cmbMes" id="cmbMes" style="font:normal normal 8pt tahoma;width:120px" onchange="GeneraObjeto('CambiaPlanta','cor020300_dat.php?TIP=11&ANO=' + document.all('cmbAno').value + '&MES=' + this.value)"><option value=''>:: MES ::</option></select>&nbsp;</td>
                                                                                <td style="font:bold bold 8pt tahoma;text-align:right">&nbsp;Planta&nbsp;</td><td name="tdPlanta" id="tdPlanta">&nbsp;<select style="font:normal normal 8pt tahoma;width:85px" name="cmbPlanta" id="cmbPlanta"><option value=''>:: PLANTA ::</option></select>&nbsp;</td>
                                                                                <td><img title="Visualizar en Excel" src="images/excel.jpg" border=0 style="cursor:hand" onClick="VerExcel(this)"><img title="Visualizar en PDF" src="images/pdf.jpg" border=0 style="cursor:hand" onClick="VerPDF(this)"></a>&nbsp;</td>
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
