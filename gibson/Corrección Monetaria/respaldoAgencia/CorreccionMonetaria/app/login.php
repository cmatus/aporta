<?php
        
    include("conexion.php");

    $lsAccion = $_GET["ACC"];
    if(trim($lsAccion)=="LOGIN"){
        /*
        $lsSQL = "SELECT login,nombre,rol FROM [907610004_cmm_usuario] WHERE login = '".trim($_POST["txtLogin"])."' AND password = '".md5(trim($_POST["txtPassword"]))."'";
        $result = mssql_query($lsSQL);
        if($row = mssql_fetch_array($result)){
            setcookie("cook_log",trim($row["login"]));
            setcookie("cook_nom",trim($row["nombre"]));
            setcookie("cook_rol",trim($row["rol"]));
            echo "<script>document.location.replace('cor010100.php')</script>";
        }
        */
        $lsSQL = "SELECT login,nombre,rol FROM [907610004_cmm_usuario] WHERE login = '".trim($_POST["txtLogin"])."' AND password = '".md5(trim($_POST["txtPassword"]))."'";
        $stmt = sqlsrv_query($conn, $lsSQL);
        if(!$stmt) {
            die(print_r( sqlsrv_errors(), true) );
        } else {
            if($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                setcookie("cook_log",trim($row["login"]));
                setcookie("cook_nom",trim($row["nombre"]));
                setcookie("cook_rol",trim($row["rol"]));
                echo "<script>document.location.replace('cor010100.php')</script>";
            }
        }
    }
    
?>
<html>
<head runat="server">
    <title>Untitled Page</title>
    <script>
        function ValidaDatos(){
            if(document.all("txtLogin").value==""){
                alert("Debe ingresar login de usuario");
                document.all("txtLogin").focus();
            } else{
                if(document.all("txtPassword").value==""){
                    alert("Debe ingresar password de usuario");
                    document.all("txtPassword").focus();
                } else{
                    document.thisform.submit();
                }
            }
        }
    </script>
</head>
<body>
    <form method="post" name="thisform" runat="server" action="login.php?ACC=LOGIN">
        <table style="border:1px solid silver;width:400px" align="center">
            <tr height=20><td style="background-Color:#5b7d9b;text-align:center;font:normal normal 10pt tahoma,arial,helvetica,sans-serif;color:white"><b>Inicio de Sesi&oacute;n</b></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;&nbsp;&nbsp;<img src="images/mainlogo_full.gif" /></td></tr>
            <tr style="height:90px">
                <td align="center">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align:right;font:bold bold 10pt tahoma,arial,helvetica,sans-serif">&nbsp;Login&nbsp;</td>
                            <td>&nbsp;<input name="txtLogin" id="txtLogin" type="text" style="width:150px;border:1px solid silver"/>&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:right;font:bold bold 10pt tahoma,arial,helvetica,sans-serif">&nbsp;Password&nbsp;</td>
                            <td>&nbsp;<input name="txtPassword" id="txtPassword" type="password" style="width:150px;border:1px solid silver"/>&nbsp;</td>
                        </tr>
                        <tr height=30>
                            <td style="text-align:right" colspan="2">&nbsp;<input type="button" style="width:104px;border:1px solid silver;font:bold bold 10pt tahoma,arial,helvetica,sans-serif" value="Entrar" onclick="ValidaDatos()"/>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
        </table>
    </form>
</body>
</html>
