<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    
    $target_path = "files/variacion.xls";
    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)){
        
        require_once 'Excel/reader.php';
        $data = new Spreadsheet_Excel_Reader();
        
        $data->setOutputEncoding("CP1251");
        $data->read($target_path);
        
        error_reporting(E_ALL ^ E_NOTICE);
        
        for ($i=2;$i<=$data->sheets[0]["numRows"];$i++){
            $data->sheets[0]["numCols"]; // Columnas
            $lsEXCEL_moneda  = trim($data->sheets[0]["cells"][$i][1]);
            $lsEXCEL_ano     = trim($data->sheets[0]["cells"][$i][2]);
            $lsEXCEL_primero = trim($data->sheets[0]["cells"][$i][3]);
            $lsEXCEL_segundo = trim($data->sheets[0]["cells"][$i][4]);
            $lsEXCEL_anual   = trim($data->sheets[0]["cells"][$i][5]);
            $lsSQL = "DELETE FROM [907610004_cmm_variacionporcentual] WHERE id_moneda = '".$lsEXCEL_moneda."' AND ano = '".$lsEXCEL_ano."'";
            mssql_query($lsSQL);
            $lsSQL = "INSERT INTO [907610004_cmm_variacionporcentual](id_moneda,ano,primero,segundo,anual) VALUES(".$lsEXCEL_moneda.",'".$lsEXCEL_ano."',".$lsEXCEL_primero.",".$lsEXCEL_segundo.",".$lsEXCEL_anual.")";
            mssql_query($lsSQL);
        }
        
    }
    
?>
<html>
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <form enctype="multipart/form-data" name="thisform" action="cor040100.php?ACC=SUBIR" method="post">
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
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:1px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Variaci&oacute;n porcentual</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor040200.php')">&nbsp;&nbsp;&nbsp;Saldos iniciales</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor040300.php')">&nbsp;&nbsp;&nbsp;Saldos finales</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('cor040400.php')">&nbsp;&nbsp;&nbsp;Correcci&oacute;n monetaria</td></tr>
                                                    <tr><td height="200" align="center" valign="top" style="border-right:1px solid silver"><img src="images/borderbox_bottom.jpg" /></td></tr>
                                                </table>
                                            </td>
                                            <td align="left" valign="top" align="center">
                                                <table cellpadding="0" cellspacing="0" width="745" height="455">
                                                    <tr>
                                                        <td style="border-top:1px solid silver;border-right:1px solid silver;border-bottom:1px solid silver" align="center">
                                                            <table cellpadding="0" cellspacing="0" name="tabPlantas" id="tabPlantas">
                                                                <tr height=20 bgcolor='#8cb6ff'>
                                                                    <td style='width:30px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>#</b>&nbsp;</td>
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>Moneda</b>&nbsp;</td>
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>1er. sem.</b>&nbsp;</td>
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>2do. sem.</b>&nbsp;</td>
                                                                    <td style='width:80px;color:white;font:normal normal 7pt tahoma;border-top:1px solid silver;border-bottom:1px solid silver;border-right:1px solid white;border-left:0px solid silver' align='center'>&nbsp;<b>Anual</b>&nbsp;</td>
                                                                </tr>
                                                                <?php
                                                                    $lsSQL = "
                                                                    SELECT	CASE
                                                                    			WHEN id_moneda = 0   THEN 'PESO'
                                                                    			WHEN id_moneda = 13  THEN 'DOLAR'
                                                                    			WHEN id_moneda = 142 THEN 'EURO'
                                                                    		END AS moneda,
                                                                    		primero,
                                                                    		segundo,
                                                                    		anual
                                                                    FROM	[907610004_cmm_variacionporcentual]
                                                                    WHERE	ano = '".$lsAno."'";
                                                                    
                                                                    $result = mssql_query($lsSQL);
                                                                    
                                                                    $liCount = 1;
                                                                    while($row = mssql_fetch_array($result)){
                                                                        
                                                                        echo "
                                                                        <tr height=23>
                                                                        <td style='width:30px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:1px solid silver' align='right' bgcolor='#ededed'>&nbsp;<b>".trim($liCount)."</b>&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='left'>&nbsp;".trim($row["moneda"])."&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".trim($row["primero"])."&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".trim($row["segundo"])."&nbsp;</td>
                                                                        <td style='width:80px;color:gray;font:normal normal 7pt tahoma;border-top:0px solid silver;border-bottom:1px solid silver;border-right:1px solid silver;border-left:0px solid silver' align='right'>&nbsp;".trim($row["anual"])."&nbsp;</td>
                                                                        </tr>";
                                                                        $liCount++;
                                                                        
                                                                    }
                                                                    
                                                                ?>
                                                                <tr>
                                                                    <td colspan=5>
                                                                        <input type="file" name="uploadedfile" id="uploadedfile" style="font:normal normal 8pt tahoma;border:1px solid silver;width:250px">
                                                                        <input type="submit" style="font:normal normal 8pt tahoma;border:1px solid silver;width:120px;height:20px" value="Subir a SLI">
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
</html>
