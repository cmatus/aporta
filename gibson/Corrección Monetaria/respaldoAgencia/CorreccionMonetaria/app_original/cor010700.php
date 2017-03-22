<?php

    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
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
                                    if(trim($data->sheets[0]["cells"][$i][1])!=""&&(trim($data->sheets[0]["cells"][$i][16])!=""||trim($data->sheets[0]["cells"][$i][3])!="")&&trim($data->sheets[0]["cells"][$i][5])!=""&&trim($data->sheets[0]["cells"][$i][11])!=""&&trim($data->sheets[0]["cells"][$i][12])!=""&&trim($data->sheets[0]["cells"][$i][13])!=""){
                                        switch(trim($data->sheets[0]["cells"][$i][13])){
                                            case "CLP":
                                                $lsMoneda = "1";
                                                break;
                                            case "EUR":
                                                $lsMoneda = "142";
                                                break;
                                            case "USD":
                                                $lsMoneda = "13";
                                                break;
                                        }
                                        if(trim($data->sheets[0]["cells"][$i][16])!=""&&trim($data->sheets[0]["cells"][$i][16])!="0"){
                                            $lsSQL = "UPDATE CLIENTES..factura_enc SET fecha = '".date("Y-m-d",mktime(0,0,0,1,$data->sheets[0]["cells"][$i][12]-36891,1))."', id_moneda = ".$lsMoneda.", direccion = '".trim($data->sheets[0]["cells"][$i][11])."', valorcif = ".trim($data->sheets[0]["cells"][$i][14])." WHERE num_facturainterno = '".trim($data->sheets[0]["cells"][$i][16])."' AND id_cliente = '907610004' AND fecha IS NULL";
                                            //mssql_query($lsSQL);
                                            if(trim($data->sheets[0]["cells"][$i][17])!=""){
                                                $lsSQL = "UPDATE [907610004_cmm_libroexistencias] SET po = '".trim($data->sheets[0]["cells"][$i][17])."', descripcion = '".trim($data->sheets[0]["cells"][$i][16])."@".date("Y-m-d",mktime(0,0,0,1,$data->sheets[0]["cells"][$i][15]-36891,1))."' WHERE referencia = '".trim($data->sheets[0]["cells"][$i][3])."' AND cod_proveedor = '".trim($data->sheets[0]["cells"][$i][5])."'";
                                            } else{
                                                $lsSQL = "UPDATE [907610004_cmm_libroexistencias] SET descripcion = '".trim($data->sheets[0]["cells"][$i][2])."@".trim($data->sheets[0]["cells"][$i][16])."@".date("Y-m-d",mktime(0,0,0,1,$data->sheets[0]["cells"][$i][15]-36891,1))."' WHERE referencia = '".trim($data->sheets[0]["cells"][$i][3])."' AND cod_proveedor = '".trim($data->sheets[0]["cells"][$i][5])."'";
                                            }
                                            //echo $lsSQL."<br>";
                                            mssql_query($lsSQL);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                }
                
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
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <form enctype="multipart/form-data" name="thisform" action="cor010700.php?ACC=SUBIR" method="post">
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
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010400.php')">&nbsp;&nbsp;&nbsp;Compras sin despacho</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010500.php')">&nbsp;&nbsp;&nbsp;Facturas en tránsito SLI (PM)</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor010600.php')">&nbsp;&nbsp;&nbsp;Embarques sin factura SLI (PM)</td></tr>
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Facturas sin fecha</td></tr>
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
                                                                    <td style='width:40px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b><?=trim(date("Y")-2)?></b>&nbsp;</td>
                                                                    <td style='width:40px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b><?=trim(date("Y")-1)?></b>&nbsp;</td>
                                                                    <td style='width:40px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b><?=trim(date("Y")-0)?></b>&nbsp;</td>
                                                                    <td style='width:65px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center' colspan=2>&nbsp;<b>TOTAL</b>&nbsp;</td>
                                                                </tr>
                                                                <?php
                                                                    
                                                                    $lsSQL = "
                                                                    SELECT	DIV.cod_division planta,
                                                                    		SUM(CASE WHEN YEAR(fec_archivo) = YEAR(GETDATE())-2 THEN 1 ELSE 0 END) uno,
                                                                    		SUM(CASE WHEN YEAR(fec_archivo) = YEAR(GETDATE())-1 THEN 1 ELSE 0 END) dos,
                                                                    		SUM(CASE WHEN YEAR(fec_archivo) = YEAR(GETDATE())-0 THEN 1 ELSE 0 END) tre,
                                                                    		count(1) tot
                                                                    FROM	CLIENTES..factura_enc FAC INNER JOIN CLIENTES..division DIV ON FAC.id_pd = DIV.id_division
                                                                    WHERE	(FAC.fecha IS NULL OR FAC.fecha = '19000101') AND
                                                                    		FAC.fec_archivo IS NOT NULL
                                                                    GROUP	BY
                                                                    		DIV.cod_division
                                                                    ORDER	BY
                                                                    		DIV.cod_division";
                                                                    $result = mssql_query($lsSQL);
                                                                    
                                                                    $liCount = 1;
                                                                    while($row = mssql_fetch_array($result)){
                                                                        
                                                                        echo "
                                                                        <tr height=23>
                                                                        <td style='width:30px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:1px solid silver' align='right' bgcolor='#ededed'>&nbsp;<b>".trim($liCount)."</b>&nbsp;</td>
                                                                        <td style='width:50px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='left'>&nbsp;".trim($row["planta"])."&nbsp;</td>
                                                                        <td style='width:40px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["uno"]),0)."&nbsp;</td>
                                                                        <td style='width:40px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["dos"]),0)."&nbsp;</td>
                                                                        <td style='width:40px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".number_format(trim($row["tre"]),0)."&nbsp;</td>
                                                                        <td style='width:43px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;<b>".number_format(trim($row["tot"]),0)."</b>&nbsp;</td>
                                                                        <td style='width:22px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='center'><a href='cor010000.php?TIP=3&PLA=".trim($row["planta"])."' target='_blank'><img border=0 src='images/excel.jpg'></a></td>
                                                                        </tr>";
                                                                        $liCount++;
                                                                        
                                                                    }
                                                                    
                                                                ?>
                                                            </table>
                                                            <br>
                                                            <table cellpadding=0 cellspacing=0>
                                                                <tr>
                                                                    <td style="font:bold bold 8pt tahoma;text-align:right">Archivo&nbsp;&nbsp;</td>
                                                                    <td><input type="file" name="uploadedfile" id="uploadedfile" style="border:1px solid silver;height:20px;font:normal normal 8pt tahoma;width:500px"></td>
                                                                    <td>&nbsp;<input type="submit" style="font:normal normal 8pt tahoma;border:1px solid silver;width:120px;height:20px" value="Subir a SLI"></td>
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
</html>
