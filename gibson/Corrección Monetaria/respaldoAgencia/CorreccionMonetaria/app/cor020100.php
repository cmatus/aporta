<?php
        
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    set_time_limit(0);
    $lsAccion = $HTTP_GET_VARS["ACC"];
    //$lsAno    = $HTTP_GET_VARS["ANO"];
    
    if(trim($lsAccion)=="SUBIR"){
        //echo $lsAccion;
        $target_path = "D:\inetpub\wwwroot\philips\files\archivo.zip";
        $target_pat2 = "D:\inetpub\wwwroot\philips\files\archivo.txt";
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)){
        
            $zip = zip_open($target_path);
            if($zip){
                
                while ($zip_entry = zip_read($zip)) {
                    
                    /*
                    echo "Name:               " . zip_entry_name($zip_entry) . "<br>";
                    echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "<br>";
                    echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "<br>";
                    echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "<br>";
                    */
                    
                    if (zip_entry_open($zip, $zip_entry, "r")){
                        
                        $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                        if($handle=fopen($target_pat2,"w")){
                            if(fwrite($handle,$buf)){
                                
                    			$lsMes    = $HTTP_POST_VARS["hdnMes"];
                    			$lsPlanta = $HTTP_POST_VARS["hdnPlanta"];
                                
                                $lsSQL = "DELETE FROM [907610004_cmm_libroexistencias] WHERE mes = '".$lsMes."' AND planta = '".$lsPlanta."'";
                                if(mssql_query($lsSQL)){
                
                                    echo "<table>";
                                    $lsFile = fopen($target_pat2, "r");
                
                                    $lbFlag = false;
                        			while(($lsContenido = fgets($lsFile))!==false){
                                        
                                        $lsPlanta = str_replace(" ","",trim(substr($lsContenido,45,4)));                
                                        if(substr($lsPlanta,0,2)=="CL"){
                                        
                                            if(str_replace(" ","",trim(substr($lsContenido,20,20)))!=""){
                                                $lsArticulo = str_replace(" ","",trim(substr($lsContenido,20,20)));
                                            }
                                            
                                            $lsSQL = "
                                            INSERT  INTO [907610004_cmm_libroexistencias](
                                                    mes,
                                                    articulo,
                                                    planta,
                                                    bodega,
                                                    cantidad,
                                                    unidad,
                                                    valor,
                                                    moneda,
                                                    costo,
                                                    mov_tipo,
                                                    mov_desc,
                                                    mov_reg,
                                                    docto_num,
                                                    docto_fec,
                                                    referencia,
                                                    proveedor
                                            ) VALUES(
                                                    '".trim($lsMes)."',
                                                    '".trim($lsArticulo)."',
                                                    '".str_replace("'","`",trim(substr($lsContenido,45,4)))."',
                                                    '".str_replace("'","`",trim(substr($lsContenido,53,10)))."',
                                                     ".str_replace(",",".",rgZero(trim(substr($lsContenido,75,1)).trim(str_replace(".","",substr($lsContenido,67,8))))).",
                                                    '".str_replace("'","`",trim(substr($lsContenido,77,10)))."',
                                                     ".rgNull(trim(substr($lsContenido,98,1)).trim(str_replace(".","",substr($lsContenido,87,11)))).",
                                                    '".str_replace("'","`",trim(substr($lsContenido,100,3)))."',
                                                     ".rgNull(trim(str_replace(".","",substr($lsContenido,103,10)))).",
                                                    '".str_replace("'","`",trim(substr($lsContenido,113,9)))."',
                                                    '".str_replace("'","`",trim(substr($lsContenido,124,20)))."',
                                                    '".str_replace("'","`",trim(substr($lsContenido,144,9)))."',
                                                    '".str_replace("'","`",trim(substr($lsContenido,153,16)))."',
                                                    '".rgFecha(str_replace(".","-",trim(substr($lsContenido,169,10))))."',
                                                    '".str_replace("'","`",trim(substr($lsContenido,181,13)))."',
                                                    '".str_replace("'","`",trim(substr($lsContenido,194,31)))."')";
                                            
                                            if(!mssql_query($lsSQL)){
                                                echo "<tr><td nowrap>".$lsSQL."</td></tr>";
                                            } else{
                                                $lbFlag = true;
                                            }
                                            
                                        }
                                        
                        			}
                        			echo "</table>";
                        			fclose($lsFile);
    			
                                }
                            }
                        }
                        zip_entry_close($zip_entry);
                    }
                    echo "<br>";
                }
                zip_close($zip);
            }
            
        }
        
    }
    
    function rgNull($iValor){
        if(trim($iValor)==""){
            return "NULL";
        } else{
            return trim($iValor);
        }
    }
    
    function rgZero($iValor){
        if(trim($iValor)==""){
            return "0";
        } else{
            return trim($iValor);
        }
    }
    
    function rgFecha($iFecha){
        $laFecha = split("-",$iFecha);
        return $laFecha[2].$laFecha[1].$laFecha[0];
    }
    
?>
<html>
    <head id="Head1" runat="server">
        <title>Página sin título</title>
        <script>
            
            var giObj_txt;
            
            function ValidaSubida(){
                if(document.all("uploadedfile").value!=""){
                    if(document.all("txtPlanta").value!=""){
                        if(document.all("txtMes").value!=""){
                            document.thisform.submit();
                        } else{
                            alert("Debe indicar mes de proceso");
                        }
                    } else{
                        alert("Debe indicar planta");
                    }
                } else{
                    alert("Debe indicar archivo a subir");
                }
            }
            
            function TraeMaestro(iMaestro){
                
    			var xx = giObj_txt.offsetLeft;
    			var yy = giObj_txt.offsetTop;
    			
    			while(giObj_txt.offsetParent){
    				if(giObj_txt==document.getElementsByTagName('body')[0]){
    					break;
    				} else{
    					xx   = xx + giObj_txt.offsetParent.offsetLeft;
    					yy   = yy + giObj_txt.offsetParent.offsetTop;
    					giObj_txt = giObj_txt.offsetParent;
    				}
    			}
    			
                if(document.all("divMaestro").innerHTML!="&nbsp;"){
                    lsHTML = "&nbsp;";
                    document.all("divMaestro").style.visibility = "hidden";                
                } else{
                    
                    switch(iMaestro){
                        case 1:
                            lsHTML = "<table cellpadding=0 cellspacing=0 bgcolor='lightyellow' style='cursor:hand;width:248px'>";
                            lsHTML = lsHTML + "<tr onclick='CambiaValor(document.thisform(\"txtPlanta\"),\"CL00 LIGHTING\",\"CL00\")' onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;CL00&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;LIGHTING&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onclick='CambiaValor(document.thisform(\"txtPlanta\"),\"CL10 CONSUMER ELECTRONICS\",\"CL10\")' onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;CL10&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;CONSUMER ELECTRONICS&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onclick='CambiaValor(document.thisform(\"txtPlanta\"),\"CL11 CE IQUIQUE\",\"CL11\")' onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;CL11&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;CE IQUIQUE&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onclick='CambiaValor(document.thisform(\"txtPlanta\"),\"CL70 DAP\",\"CL70\")' onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;CL70&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;DAP&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onclick='CambiaValor(document.thisform(\"txtPlanta\"),\"CL71 DAP IQUQUE\",\"CL71\")' onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;CL71&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;DAP IQUIQUE&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onclick='CambiaValor(document.thisform(\"txtPlanta\"),\"CL90 SISTEMAS MEDICOS\",\"CL90\")' onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"'><td style='border-bottom:0px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;CL90&nbsp;</td><td style='border-bottom:0px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;SISTEMAS MEDICOS&nbsp;</td></tr>";
                            lsHTML = lsHTML + "</table>";
                            break;
                        case 2:
                            lsHTML = "<table cellpadding=0 cellspacing=0 bgcolor='lightyellow' style='cursor:hand;width:248px'>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"ENERO <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>01\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;ENERO&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"FEBRERO <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>02\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;FEBRERO&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"MARZO <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>03\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;MARZO&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"ABRIL <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>04\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;ABRIL&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"MAYO <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>05\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;MAYO&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"JUNIO <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>06\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;JUNIO&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"JULIO <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>07\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;JULIO&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"AGOSTO <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>08\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;AGOSTO&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"SEPTIEMBRE <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>09\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;SEPTIEMBRE&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"OCTUBRE <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>10\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;OCTUBRE&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"NOVIEMBRE <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>11\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;NOVIEMBRE&nbsp;</td></tr>";
                            lsHTML = lsHTML + "<tr onmouseover='this.style.backgroundColor=\"#ededed\"' onmouseout='this.style.backgroundColor=\"lightyellow\"' onclick='CambiaValor(document.thisform(\"txtMes\"),\"DICIEMBRE <?=trim($lsAno)?>\",\"<?=trim($lsAno)?>12\")'><td style='border-bottom:1px solid silver;border-right:1px solid silver;font:normal 8pt tahoma'>&nbsp;<?=trim($lsAno)?>&nbsp;</td><td style='border-bottom:1px solid silver;border-right:0px solid silver;font:normal 8pt tahoma'>&nbsp;DICIEMBRE&nbsp;</td></tr>";
                            lsHTML = lsHTML + "</table>";
                            break;
                    }
                    divMaestro.style.visibility = "visible";
                    
                }
                
                document.all("divMaestro").innerHTML = lsHTML;
    			divMaestro.style.top  = yy + 20;
    			divMaestro.style.left = xx;
                
            }
            
            function CambiaValor(iTexto,iValor,iHidden){
                
                iTexto.value = iValor;
                document.all("divMaestro").innerHTML = "&nbsp;";
                document.all("divMaestro").style.visibility = "hidden";
                
                switch(iTexto.name){
                    case "txtPlanta":
                        document.all("hdnPlanta").value = iHidden;
                        break;
                    case "txtMes":
                        document.all("hdnMes").value = iHidden;
                        break;
                }
                
            }
            
        </script>
    </head>
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <div name="divMaestro" id="divMaestro" style="border:1px solid silver;position:absolute;visibility:hidden;z-index:1">&nbsp;</div>
        <form enctype="multipart/form-data" name="thisform" action="cor020100.php?ACC=SUBIR" method="post">
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
                                        <tr height="35"><td colspan="2" align="right" style="color:#005aff;font:bold bold 13pt tahoma"><b>Existencias <?=$lsAno?></b>&nbsp;&nbsp;</td></tr>
                                        <tr>
                                            <td align="left" width="200" valign="top">
                                                <table cellpadding="0" cellspacing="0" height="455">
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:1px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Carga archivo texto</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onMouseOver="this.style.font='bold bold 8pt tahoma'" onMouseOut="this.style.font='normal normal 8pt tahoma'" nowrap onClick="document.location.replace('cor020200.php')">&nbsp;&nbsp;&nbsp;Carga planilla Excel</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onMouseOver="this.style.font='bold bold 8pt tahoma'" onMouseOut="this.style.font='normal normal 8pt tahoma'" nowrap onClick="document.location.replace('cor020300.php')">&nbsp;&nbsp;&nbsp;Libro de existencias</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onMouseOver="this.style.font='bold bold 8pt tahoma'" onMouseOut="this.style.font='normal normal 8pt tahoma'" nowrap onClick="document.location.replace('cor020500.php')">&nbsp;&nbsp;&nbsp;Cambio de año</td></tr>
                                                    <tr><td height="221" align="center" valign="top" style="border-right:1px solid silver"><img src="images/borderbox_bottom.jpg" /></td></tr>
                                                </table>
                                            </td>
                                            <td align="left" valign="top">
                                                <table cellpadding="0" cellspacing="0" width="745" height="455">
                                                    <tr>
                                                        <td style="border-top:1px solid silver;border-right:1px solid silver;border-bottom:1px solid silver" align="center">
                                                        <?if(trim($lsAccion)!="SUBIR"){?>
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td style="font:bold bold 8pt tahoma;text-align:right">Archivo&nbsp;&nbsp;</td>
                                                                    <td><input type="file" name="uploadedfile" id="uploadedfile" style="font:normal normal 8pt tahoma;border:1px solid silver;width:650px"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font:bold bold 8pt tahoma;text-align:right">Planta&nbsp;&nbsp;</td>
                                                                    <td>
                                                                        <table cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td><input type="text" name="txtPlanta" id="txtPlanta" style="font:normal normal 8pt tahoma;border:1px solid silver;width:250px" readonly></td>
                                                                                <td><img src="images/combo.jpg" style="margin-left:2px;cursor:hand" onClick="giObj_txt=document.thisform('txtPlanta');TraeMaestro(1)"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font:bold bold 8pt tahoma;text-align:right">Mes&nbsp;&nbsp;</td>
                                                                    <td>
                                                                        <table cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td><input type="hidden" name="hdnPlanta"><input type="hidden" name="hdnMes"><input type="text" name="txtMes" id="txtMes" style="font:normal normal 8pt tahoma;border:1px solid silver;width:250px" readonly></td>
                                                                                <td><img src="images/combo.jpg" style="margin-left:2px;cursor:hand" onClick="giObj_txt=document.thisform('txtMes');TraeMaestro(2)"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr><td>&nbsp;</td><td><input type="button" value="Subir a SLI" onClick="ValidaSubida()" style="font:normal normal 8pt tahoma;border:1px solid silver;width:120px;height:20px"></td></tr>
                                                            </table>
                                                        <?} else{?>
                                                            <?if($lbFlag){?>
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr><td width=350 height=25 style="border:1px solid silver;color:gray;font:normal normal 8pt tahoma" align="center"><b>Archivo procesado</b></td></tr>
                                                                    <tr><td height=25 align="center"><input type="button" style="font:normal normal 8pt tahoma;border:1px solid silver;width:150px;height:20px" value="Subir otro" onClick="document.location.replace('cor020100.php')"></td></tr>
                                                                </table>
                                                            <?} else{?>
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr><td width=350 height=25 style="border:1px solid silver;color:gray;font:normal normal 8pt tahoma" align="center"><b>Archivo no procesado, formato incorrecto</b></td></tr>
                                                                    <tr><td height=25 align="center"><input type="button" style="font:normal normal 8pt tahoma;border:1px solid silver;width:150px;height:20px" value="Volver" onClick="document.location.replace('cor020100.php')"></td></tr>
                                                                </table>
                                                            <?}?>
                                                        <?}?>
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
