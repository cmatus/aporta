<?php

    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    
    $lsAccion = $HTTP_GET_VARS["ACC"];
    if(trim($lsAccion)=="GRABAR"){
        $lsSQL = "INSERT INTO [907610004_cmm_usuario](nombre,login,password,rol) VALUES('".trim($HTTP_POST_VARS["txtNombre"])."','".trim($HTTP_POST_VARS["txtLogin"])."','".md5(trim($HTTP_POST_VARS["txtPassword"]))."',".trim($HTTP_POST_VARS["txtCodRol"]).")";
        mssql_query($lsSQL);
        echo "<script>alert('Usuario registrado');</script>";
    }
    
?>
<html>
    <head runat="server">
        <title>:: Prosotec S.A. :: Creación de usuario ::</title>
        <script>
            function ValidaDatos(){
                if(document.thisform.txtNombre.value!=""){
                    if(document.thisform.txtLogin.value!=""){
                        if(document.thisform.txtPassword.value!=""){
                            if(document.thisform.txtCodRol.value!=""){
                                document.thisform.submit();
                            } else{
                                alert("Debe registrar un Rol para el usuario");
                                return false;
                            }
                        } else{
                            alert("Debe registrar un Password para el usuario");
                            return false;
                        }
                    } else{
                        alert("Debe registrar un Login para el usuario");
                        return false;
                    }
                } else{
                    alert("Debe registrar un Nombre para el usuario");
                    return false;
                }
            }
            function ValidaRol(valor){
                if(valor.keyCode==48||valor.keyCode==49||valor.keyCode==50){
                    switch(valor.keyCode){
                        case 48:
                            document.thisform.txtRol.value = "ADMINISTRADOR";
                            document.thisform.txtCodRol.value = "0";
                            break;
                        case 49:
                            document.thisform.txtRol.value = "CONTABILIDAD";
                            document.thisform.txtCodRol.value = "1";
                            break;
                        case 50:
                            document.thisform.txtRol.value = "CONTROLLER";
                            document.thisform.txtCodRol.value = "2";
                            break;
                    }
                } else{
                    valor.returnValue = false;
                    document.thisform.txtRol.value = "";
                    document.thisform.txtCodRol = "";
                }
            }
        </script>
    </head>
    <body background="images/titulo.jpg" topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>
        <form method="post" name="thisform" runat="server" action="cor050100.php?ACC=GRABAR">
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
                                        <tr height="35"><td colspan="2" align="right" style="color:#005aff;font:bold bold 13pt tahoma"><b>Crear usuario</b>&nbsp;&nbsp;</td></tr>
                                        <tr>
                                            <td align="left" width="200" valign="top">
                                                <table cellpadding="0" cellspacing="0" height="455">
                                                    <tr><td background="images/manu.jpg" style="color:gray;font:bold bold 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:1px solid silver;border-left:1px solid silver;border-right:0px solid silver" nowrap>&nbsp;&nbsp;&nbsp;Crear usuario</td></tr>
                                                    <tr><td style="color:gray;font:normal normal 8pt tahoma;width:200px;height:35px;border-bottom:1px solid silver;border-top:0px solid silver;border-left:1px solid white; border-right:1px solid silver;cursor:hand" onmouseover="this.style.font='bold bold 8pt tahoma'" onmouseout="this.style.font='normal normal 8pt tahoma'" nowrap onclick="document.location.replace('logout.php')">&nbsp;&nbsp;&nbsp;Cerrar sesión</td></tr>
                                                    <tr><td height="100" align="center" valign="top" style="border-right:1px solid silver"><img src="images/borderbox_bottom.jpg" /></td></tr>
                                                </table>
                                            </td>
                                            <td align="left" valign="top">
                                                <table cellpadding="0" cellspacing="0" width="745" height="455">
                                                    <tr>
                                                        <td style="border-top:1px solid silver;border-right:1px solid silver;border-bottom:1px solid silver" align="center">
                                                           <table style="border:1px solid silver;width:400px" align="center">
                                                                <tr><td>&nbsp;</td></tr>
                                                                <tr style="height:90px">
                                                                    <td align="center">
                                                                        <table cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td style="text-align:right;font:bold bold 10pt tahoma,arial,helvetica,sans-serif">&nbsp;Nombre&nbsp;</td>
                                                                                <td>&nbsp;<input name="txtNombre" id="txtNombre" type="text" style="width:300px;border:1px solid silver"/>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:right;font:bold bold 10pt tahoma,arial,helvetica,sans-serif">&nbsp;Login&nbsp;</td>
                                                                                <td style="text-align:left">&nbsp;<input name="txtLogin" id="txtLogin" type="text" style="width:150px;border:1px solid silver"/>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:right;font:bold bold 10pt tahoma,arial,helvetica,sans-serif">&nbsp;Password&nbsp;</td>
                                                                                <td style="text-align:left">&nbsp;<input name="txtPassword" id="txtPassword" type="password" style="width:150px;border:1px solid silver"/>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:right;font:bold bold 10pt tahoma,arial,helvetica,sans-serif">&nbsp;Rol&nbsp;</td>
                                                                                <td style="text-align:left">&nbsp;<input type="hidden" name="txtCodRol"><input name="txtRol" id="txtRol" type="text" style="width:150px;border:1px solid silver" onkeyup="ValidaRol(event)"/>&nbsp;</td>
                                                                            </tr>
                                                                            <tr height=30>
                                                                                <td>&nbsp;</td>
                                                                                <td style="text-align:left">&nbsp;<input type="button" style="width:104px;border:1px solid silver;font:bold bold 10pt tahoma,arial,helvetica,sans-serif" value="Salir" onclick="document.location.replace('cor010100.php')"/><input type="button" style="margin-left:2px;width:104px;border:1px solid silver;font:bold bold 10pt tahoma,arial,helvetica,sans-serif" value="Crear" onclick="ValidaDatos()"/>&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr><td>&nbsp;</td></tr>
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
