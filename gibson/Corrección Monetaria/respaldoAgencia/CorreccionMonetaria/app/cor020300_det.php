<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    
?>
<html>
    <head>
        <LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
        <script language="JavaScript" type="text/JavaScript" src="funciones.js"></script>
        <script>
            
            function CierraVentana(){
                var par = window.parent.document;
                par.all("divProcesar").style.visibility = 'hidden';                
            }
            
            function MuestraDetalle(){
                if((xmlhttp.readyState==4)){
                    document.all("tdDetalle").innerHTML = xmlhttp.responseText;
                    CargandoDatos(0,document.all("tabVentana"));
                }
            }
            
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
            
            var giPR;
            var giTR;
            var giTD;
            var giXX;
            
            function ProcesarDatos(iDato){
				//alert('TEST')
				//return true;
                giTR     = document.all("tabPlantas").getElementsByTagName("tr");
                laPlanta = giTR[iDato].getElementsByTagName("td")[1].innerHTML.split("&nbsp;")
                lsURL    = "cor020300_dat.php?TIP=" + giPR + "&PLA=" + laPlanta[1];
                giTD     = giTR[iDato].getElementsByTagName("td")[giPR];
                giXX     = iDato + 1;
                //alert(lsURL);
				//return true;
				//document.getElementById('txta').value=lsURL
                giTD.innerHTML = "<img src='images/loading.gif' height=20>";
                GeneraObjeto("MuestraPlanta",lsURL);
                
            }
            
            function MuestraPlanta(){
                if((xmlhttp.readyState==4)){
                    lsDatos = xmlhttp.responseText;
					//alert(lsDatos);
                    if(lsDatos!=""){
						document.getElementById('txta').value=lsDatos
                        //laError = lsDatos.split("@@");
                        //lsError = laError[0] + "\n" + laError[1] + "\n" + laError[2] + "\n" + laError[3] + "\n" + laError[4];
                        giTD.innerHTML = "<img src='images/error.jpg'>";
						return false;
                    } else{
                        giTD.innerHTML = "<img src='images/ok.jpg'>";
                    }
                    if(giTR.length-1>giXX){
                        ProcesarDatos(giXX);
                    } else{
                        if(giPR<8){
                            giPR++;
                            giXX = 1;
                            ProcesarDatos(giXX);
                        }
                    }
                }
            }
            
        </script>
    </head>
    <body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 name="tabVentana" id="tabVentana">
        <div name="overDiv" id="overDiv" style="position:absolute;z-index:3">&nbsp;</div>
        <form>
            <table cellpadding="0" cellspacing="0" border=0 width="360" height=249>
                <tr height=25>
                    <td nowrap width="5" align="right"><img src="http://clientes.stein.cl/apps/img/images/vent_top_l.gif"></td>
                    <td nowrap background="http://clientes.stein.cl/apps/img/images/vent_top_m.gif">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td nowrap><font color="white" class="VenTit">&nbsp;<b>PROCESO INFORMACION LIBROS <?=trim($lsAno)?></b></font></td>
                                <td nowrap width="9" style="color: #000000"><img src="http://clientes.stein.cl/apps/img/images/vent_cruz.gif" style="cursor:hand" onClick="CierraVentana()"></td>
                                <td nowrap width="5">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td nowrap width="5" align="right"><img src="http://clientes.stein.cl/apps/img/images/vent_top_r.gif"></td>
                </tr>
                <tr height=10 bgcolor="#ececec">
                    <td nowrap width="5" background="http://clientes.stein.cl/apps/img/images/vent_mid_l.gif">&nbsp;</td>
                    <td nowrap background="http://clientes.stein.cl/apps/img/images/vent_mid_m.gif"></td>
                    <td nowrap width="5" background="http://clientes.stein.cl/apps/img/images/vent_mid_r.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td nowrap width="5" background="http://clientes.stein.cl/apps/img/images/vent_mid_l.gif">&nbsp;</td>
                    <td nowrap align="center" bgcolor="#ececec" name="tdDetalle" id="tdDetalle">&nbsp;</td>
                    <td nowrap width="5" background="http://clientes.stein.cl/apps/img/images/vent_mid_r.gif">&nbsp;</td>
                </tr>
                <tr height=11 bgcolor="#ececec">
                    <td nowrap width="5" background="http://clientes.stein.cl/apps/img/images/vent_bot_l.gif">&nbsp;</td>
                    <td nowrap background="http://clientes.stein.cl/apps/img/images/vent_bot_m.gif"></td>
                    <td nowrap width="5" background="http://clientes.stein.cl/apps/img/images/vent_bot_r.gif">&nbsp;</td>
                </tr>
            </table>
        </form>
    </body>
    <script>
        CargandoDatos(1,document.all("tabVentana"));
        GeneraObjeto("MuestraDetalle","cor020300_dat.php?TIP=1&ANO=<?=trim($lsAno)?>");
    </script>
</html>
