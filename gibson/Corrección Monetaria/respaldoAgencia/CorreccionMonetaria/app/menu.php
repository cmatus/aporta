<?php
    include("seguridad.php");
?>
<html>
    <head>
        <LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
        <script language="JavaScript" type="text/JavaScript" src="funciones.js"></script>
        <script>
            
            function CargandoDatos(iTipo,iObj){
                
                liCoord_X = findPosX(iObj)
                liCoord_Y = findPosY(iObj)
                
                var lsHTML = "";
                if(iTipo==1){
                    
                    document.getElementById("overDiv").innerHTML  = "<iframe src='loading.htm' frameborder='0' scrolling='no' style='margin-left:0px;width:200px;height:60px'></iframe>";
                    document.getElementById("overDiv").style.zIndex = 3;
                    document.getElementById("overDiv").style.left = parseInt(liCoord_X) + parseInt((iObj.offsetWidth-document.getElementById("overDiv").offsetWidth)/2);
                    document.getElementById("overDiv").style.top  = parseInt(liCoord_Y) + parseInt((iObj.offsetHeight-document.getElementById("overDiv").offsetHeight)/2);
                    
                } else{
                    document.getElementById("overDiv").innerHTML  = "";
                }
            	
            }
            
            function CargaPantalla(iOpc,iPantalla){
                CambiaOpcion(iOpc.name);
                CargandoDatos(1,document.all("tdPantalla"));
                GeneraObjeto("MuestraPantalla",iPantalla); 
            }
            
            function MuestraPantalla(){
                if((xmlhttp.readyState==4)){
                    document.all("tdPantalla").innerHTML = xmlhttp.responseText;
                    CargandoDatos(0,document.all("tdPantalla"));
                }
            }
            
            function CambiaOpcion(iOpcion){
                
                document.all(iOpcion).style.borderRight = "0px solid silver";
                document.all(iOpcion).style.borderLeft  = "1px solid silver";
                document.all(iOpcion).background        = "images/manu.jpg";
                
                if(iOpcion=="tdOpc_1"){
                    document.all(iOpcion).style.borderTop = "1px solid silver";
                }
                
            }
            
            function MuestraDetalle(iPlanta,iMes){
                document.all("divBuscar").innerHTML = "<iframe src='cor010200_det.php?PLA=" + iPlanta + "&MES=" + iMes + "' frameborder='0' scrolling='no' style='margin-left:0px;width:841px;height:391px'></iframe>";
                document.all("divBuscar").style.visibility = "visible";
                UbicaObjeto(document.all("divBuscar"),document.all("tabVentana"),1);                
            }
            
        </script>
    </head>
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <div name="overDiv" id="overDiv" style="position:absolute;z-index:3">&nbsp;</div>
        <form id="form1" runat="server">
            <table cellpadding="0" cellspacing="0" width="100%" height="100%" border=0 name="tabVentana" id="tabVentana">
                <tr height="70">
                    <td align="center">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>&nbsp;&nbsp;<img src="images/mainlogo_full.gif" /></td>
                                <td align="right">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr style="height:21px">
                                            <td style="width:35px"><img src="images/topnav_border_left.gif" /></td>
                                            <td background="images/topnav_bg_on.gif" style="border-left:1px solid silver;color:gray;text-align:center;font:bold bold 8pt tahoma;width:150px">&nbsp;Inconsistencias&nbsp;</td>
                                            <td background="images/topnav_bg.gif" onmouseover="this.background='images/topnav_bg_on.gif'" onmouseout="this.background='images/topnav_bg.gif'" style="cursor:hand;border-left:1px solid silver;color:gray;text-align:center;font:normal normal 8pt tahoma;width:150px" onclick="document.location.replace('cor020100.php')">&nbsp;Existencias&nbsp;</td>
                                            <td background="images/topnav_bg.gif" onmouseover="this.background='images/topnav_bg_on.gif'" onmouseout="this.background='images/topnav_bg.gif'" style="cursor:hand;border-left:1px solid silver;color:gray;text-align:center;font:normal normal 8pt tahoma;width:150px" onclick="document.location.replace('cor030100.php')">&nbsp;Compras&nbsp;</td>
                                            <td background="images/topnav_bg.gif" onmouseover="this.background='images/topnav_bg_on.gif'" onmouseout="this.background='images/topnav_bg.gif'" style="cursor:hand;border-left:1px solid silver;cursor:hand;border-right:1px solid silver;color:gray;text-align:center;font:normal normal 8pt tahoma;width:150px" onclick="document.location.replace('cor040100.php')">&nbsp;Correcci&oacute;n&nbsp;</td>
                                            <td style="width:35px"><img src="images/topnav_border_right.gif" /></td>
                                        </tr>
                                    </table>
                                </td>
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
                                        <tr height="35"><td colspan="2" align="right" style="color:#005aff;font:bold bold 13pt tahoma"><b>Inconsistencias</b>&nbsp;&nbsp;</td></tr>
                                        <tr>
                                            <td align="left" width="200" valign="top" name="tdOpciones" id="tdOpciones"></td>
                                            <td align="left" valign="top">
                                                <table cellpadding="0" cellspacing="0" width="745" height="455">
                                                    <tr>
                                                        <td style="border-top:1px solid silver;border-right:1px solid silver;border-bottom:1px solid silver" align="center" name="tdPantalla" id="tdPantalla">&nbsp;</td>
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
    <script>
        
        var gaOpcion = Array();
        
        gaOpcion[0] = "Compras sin referencia";
        gaOpcion[1] = "Compras que no existen en SLI";
        gaOpcion[2] = "Compras sin embarque";
        gaOpcion[3] = "Compras sin despacho";
        gaOpcion[4] = "Facturas en tránsito SLI (PM)";
        gaOpcion[5] = "Embarques en tránsito SLI (PM)";
        gaOpcion[6] = "Facturas sin fecha";
        gaOpcion[7] = "Facturas sin moneda";
        gaOpcion[8] = "Facturas sin embarque";
        
        var lsHTML = "";
        
        lsHTML = lsHTML + "<table cellpadding='0' cellspacing='0' height='455'>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_1' id='tdOpc_1' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010100_scr.php\")'>&nbsp;&nbsp;&nbsp;Compras sin referencia</td></tr>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_2' id='tdOpc_2' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010200_scr.php\")'>&nbsp;&nbsp;&nbsp;Compras que no existen en SLI</td></tr>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_3' id='tdOpc_3' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010300_scr.php\")'>&nbsp;&nbsp;&nbsp;Compras sin embarque</td></tr>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_4' id='tdOpc_4' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010400_scr.php\")'>&nbsp;&nbsp;&nbsp;Compras sin despacho</td></tr>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_5' id='tdOpc_5' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010500_scr.php\")'>&nbsp;&nbsp;&nbsp;Facturas en tránsito SLI (PM)</td></tr>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_6' id='tdOpc_6' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010600_scr.php\")'>&nbsp;&nbsp;&nbsp;Embarques en tránsito SLI (PM)</td></tr>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_7' id='tdOpc_7' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010700_scr.php\")'>&nbsp;&nbsp;&nbsp;Facturas sin fecha</td></tr>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_8' id='tdOpc_8' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010800_scr.php\")'>&nbsp;&nbsp;&nbsp;Facturas sin moneda</td></tr>";
        lsHTML = lsHTML + "<tr><td name='tdOpc_9' id='tdOpc_9' style='color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand' onmouseover='this.style.font=\"bold bold 8pt tahoma\"' onmouseout='this.style.font=\"normal normal 8pt tahoma\"' nowrap onclick='CargaPantalla(this,\"cor010900_scr.php\")'>&nbsp;&nbsp;&nbsp;Facturas sin embarque</td></tr>";
        lsHTML = lsHTML + "<tr><td height='100' align='center' valign='top' style='border-right:1px solid silver'><img src='images/borderbox_bottom.jpg' /></td></tr>";
        lsHTML = lsHTML + "</table>";
        
        document.all("tdOpciones").innerHTML = lsHTML;
        
    </script>
    <div style="z-index:3;position:absolute;top:100px;visibility:hidden" name="divBuscar" id="divBuscar"></div>
    <script>CambiaOpcion("tdOpc_1");</script>
</html>
