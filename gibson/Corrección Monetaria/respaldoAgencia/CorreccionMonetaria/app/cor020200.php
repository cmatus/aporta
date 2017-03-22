<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    set_time_limit(0);
    $lsAccion = $HTTP_GET_VARS["ACC"];
    
    if(trim($lsAccion)=="SUBIR"){
        
        $target_path = "files/fechas.zip";
        $target_pat2 = "files/fechas.xls";
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
        
            $zip = zip_open($target_path);
            if($zip){
                while ($zip_entry = zip_read($zip)){
                    if (zip_entry_open($zip, $zip_entry, "r")){                            
                        $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                        if($handle=fopen($target_pat2,"w")){
                            if(fwrite($handle,$buf)){
                                require_once 'Excel/reader.php';
                                $data = new Spreadsheet_Excel_Reader();
                                
                                $data->setOutputEncoding("CP1251");
                                $data->read($target_pat2);
                
                                error_reporting(E_ALL ^ E_NOTICE);
                                
                                for ($i=2;$i<=$data->sheets[0]["numRows"];$i++){
                                    $data->sheets[0]["numCols"]; // Columnas
                                    if((trim($data->sheets[0]["cells"][$i][1])!=""&&trim($data->sheets[0]["cells"][$i][2])!=""&&trim($data->sheets[0]["cells"][$i][4])!="")&&(trim($data->sheets[0]["cells"][$i][3])!=""||trim($data->sheets[0]["cells"][$i][14])!=""||trim($data->sheets[0]["cells"][$i][19])!="")){
                                        $lsSQL = "
                                        UPDATE  [907610004_cmm_libroexistencias]
                                        SET     referencia    = '".trim($data->sheets[0]["cells"][$i][3])."',
                                                po            = '".trim($data->sheets[0]["cells"][$i][14])."',
                                                cod_proveedor = '".trim($data->sheets[0]["cells"][$i][19])."'
                                        WHERE   planta    = '".trim($data->sheets[0]["cells"][$i][1])."' AND
                                                docto_num = '".trim($data->sheets[0]["cells"][$i][2])."' AND
                                                articulo  = '".trim($data->sheets[0]["cells"][$i][4])."'";
                                        mssql_query($lsSQL);
                                    }
                                }
                                
                            }
                            fclose($handle);
                        }
                        
                    }
                }
            }
            zip_close($zip);
            
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
    </head>
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <form enctype="multipart/form-data" name="thisform" action="cor020200.php?ACC=SUBIR" method="post">
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
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor020100.php')">&nbsp;&nbsp;&nbsp;Carga archivo texto</td></tr>
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Carga planilla Excel</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor020300.php')">&nbsp;&nbsp;&nbsp;Libro de existencias</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor020500.php')">&nbsp;&nbsp;&nbsp;Cambio de año</td></tr>
                                                    <tr><td height="221" align="center" valign="top" style="border-right:1px solid silver"><img src="images/borderbox_bottom.jpg" /></td></tr>
                                                </table>
                                            </td>
                                            <td align="left" valign="top">
                                                <table cellpadding="0" cellspacing="0" width="745" height="455">
                                                    <tr>
                                                        <td style="border-top:1px solid silver;border-right:1px solid silver;border-bottom:1px solid silver" align="center">
                                                        <?if(trim($lsAccion)!="SUBIR"){?>
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tr><td style="color:gray;font:normal normal 8pt tahoma"><b>Seleccione planilla Excel a procesar</b></td></tr>
                                                                <tr><td><input type="file" name="uploadedfile" id="uploadedfile" style="font:normal normal 8pt tahoma;border:1px solid silver;width:400px"></td></tr>
                                                                <tr><td><input type="submit" style="font:normal normal 8pt tahoma;border:1px solid silver;width:120px;height:20px" value="Subir a SLI"></td></tr>
                                                            </table>
                                                        <?} else{?>
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tr><td width=350 height=25 style="border:1px solid silver;color:gray;font:normal normal 8pt tahoma" align="center"><b>Archivo procesado</b></td></tr>
                                                                <tr><td height=25 align="center"><input type="button" style="font:normal normal 8pt tahoma;border:1px solid silver;width:150px;height:20px" value="Subir otro" onclick="document.location.replace('cor020200.php')"></td></tr>
                                                            </table>
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
