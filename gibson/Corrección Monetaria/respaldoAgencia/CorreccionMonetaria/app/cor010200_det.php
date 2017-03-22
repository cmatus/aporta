<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    
    $lsPlanta = $HTTP_GET_VARS["PLA"];
    $lsMes    = $HTTP_GET_VARS["MES"];
    
    switch(substr($lsMes,4,2)){
        case "01":
            $lsNomMes = "ENERO";
            break;
        case "02":
            $lsNomMes = "FEBRERO";
            break;
        case "03":
            $lsNomMes = "MARZO";
            break;
        case "04":
            $lsNomMes = "ABRIL";
            break;
        case "05":
            $lsNomMes = "MAYO";
            break;
        case "06":
            $lsNomMes = "JUNIO";
            break;
        case "07":
            $lsNomMes = "JULIO";
            break;
        case "08":
            $lsNomMes = "AGOSTO";
            break;
        case "09":
            $lsNomMes = "SEPTIEMBRE";
            break;
        case "10":
            $lsNomMes = "OCTUBRE";
            break;
        case "11":
            $lsNomMes = "NOVIEMBRE";
            break;
        case "12":
            $lsNomMes = "DICIEMBRE";
            break;
    }
    
?>
<html>
    <head>
        <LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
        <script language="JavaScript" type="text/JavaScript" src="funciones.js"></script>
        <script>
            
            function CierraVentana(iNombre){
                var par = window.parent.document;
                par.all("divBuscar").style.visibility = 'hidden';                
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
            
            function CompruebaCambios(){
                
                var lsData = "";
                
                laFila = document.all("tabDetalle").getElementsByTagName("TR");
                for(x=0;x<laFila.length;x++){
                    laTexto = laFila[x].getElementsByTagName("INPUT");
                    if(laTexto[0].value!=laTexto[1].value||laTexto[2].value!=laTexto[3].value){
                        laDato = laTexto[0].name.split("_");
                        lsData = lsData + laDato[2] + "@@@" + laTexto[1].value + "@@@" + laTexto[3].value + "///@@///";
                    }
                }
                
                if(lsData.length>0){
                    CargandoDatos(1,document.all("divDetalle"));
                    lsData = lsData.substring(0,lsData.length-8)
                    lsURL = "cor010200_dat.php?TIP=1&PAR=" + lsData;
                    GeneraObjeto("MuestraDatos",lsURL);
                }
                
                /*
                lsDato = iTexto.name;
                laDato = lsDato.split("_");
                
                lsURL = "cor010200_dat.php?TIP=1&PRO=" + iTexto.value + "&ID=" + laDato[1];
                GeneraObjeto("MuestraDatos",lsURL);
                */ 
                
            }
            
            function MuestraDatos(){
                if((xmlhttp.readyState==4)){
                    document.all("divDetalle").innerHTML = xmlhttp.responseText;
                    CargandoDatos(0,document.all("divDetalle"));
                }
            }
            
        </script>
    </head>
    <body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0>
        <div name="overDiv" id="overDiv" style="position:absolute;z-index:3">&nbsp;</div>
        <form>
            <table cellpadding="0" cellspacing="0" border=0 width="550">
                <tr height=25>
                    <td nowrap width="5" align="right"><img src="http://clientes.stein.cl/apps/img/images/vent_top_l.gif"></td>
                    <td nowrap background="http://clientes.stein.cl/apps/img/images/vent_top_m.gif">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td nowrap><font color="white" class="VenTit">&nbsp;<b>DETALLE <?=trim($lsNomMes)." ".substr($lsMes,0,4)." PLANTA ".trim($lsPlanta)?></b></font></td>
                                <td nowrap width="9" style="color: #000000"><img src="http://clientes.stein.cl/apps/img/images/vent_cruz.gif" style="cursor:hand" onclick="CierraVentana()"></td>
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
                    <td nowrap align="center" bgcolor="#ececec">
                        <table cellpadding=0 cellspacing=0>
                            <tr>
                                <td>
                                    <div style="width:831px;overflow:hidden">
                                        <table cellpadding=0 cellspacing=0>
                                            <tr height=20 bgcolor="#ededed">
                                                <td align="center" width=30  colspan=1 class="GridTit_1">&nbsp;<b>#</b>&nbsp;</td>
                                                <td align="center" width=80  colspan=1 class="GridTit_1">&nbsp;<b>Artículo</b>&nbsp;</td>
                                                <td align="center" width=65  colspan=1 class="GridTit_1">&nbsp;<b>Nº Docto.</b>&nbsp;</td>
                                                <td align="center" width=65  colspan=1 class="GridTit_1">&nbsp;<b>P/O</b>&nbsp;</td>
                                                <td align="center" width=70  colspan=1 class="GridTit_1">&nbsp;<b>Fecha</b>&nbsp;</td>
                                                <td align="center" width=60  colspan=1 class="GridTit_1">&nbsp;<b>Cantidad</b>&nbsp;</td>
                                                <td align="center" width=60  colspan=1 class="GridTit_1">&nbsp;<b>Costo</b>&nbsp;</td>
                                                <td align="center" width=60  colspan=1 class="GridTit_1">&nbsp;<b>Valor</b>&nbsp;</td>
                                                <td align="center" width=246 colspan=1 class="GridTit_1">&nbsp;<b>Proveedor</b>&nbsp;</td>
                                                <td align="center" width=69  colspan=1 class="GridTit_1">&nbsp;<b>Referencia</b>&nbsp;</td>
                                                <td align="center" width=14  colspan=1 class="GridTit_2">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="width:831px;height:303px;overflow-y:scroll;border-bottom:1px solid silver;border-left:1px solid silver" name="divDetalle" id="divDetalle" bgcolor="white">
                                    <?php
                                        
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
                                        
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            <tr><td align="right"><input type="button" value="Actualizar" class="Button" style="width:80px;margin-top:2px" onclick="CompruebaCambios()"></td></tr>
                        </table>
                    </td>
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
</html>
