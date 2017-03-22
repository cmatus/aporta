<?php
    
    include("../SLI/SLIStandar/conexion.php");
    include("menu.inc");
    
    $lsAccion = $HTTP_GET_VARS["ACC"];
    if(trim($lsAccion)=="LOGIN"){
        
        $lsLogin    = $HTTP_POST_VARS["txtLogin"];
        $lsPassword = $HTTP_POST_VARS["txtPassword"];
        
        if(trim($lsLogin)!=""&&trim($lsPassword)!=""){
            if(trim($lsLogin)!="jcelis"){
                echo "<script>alert('Login incorrecto')</script>";
            } else{
                if(trim($lsPassword)!="joseluis"){
                    echo "<script>alert('Password incorrecto')</script>";
                } else{
                    echo "<script>document.location.replace('portada.php')</script>";
                }
            }
        }
        
    }
    
?>
<body name="theBody" id="theBody" onload="document.thisform.txtLogin.focus()">
    <form name="thisform" action="login.php?ACC=LOGIN" method="post">
        <table cellpadding=2 cellspacing=2 align="center" style="border:1px solid black;border-bottom:0px" width="200" bgcolor="blue">
            <tr><td align="center"><font size=2 color="white"><b>Seguridad</b></font></td></tr>
        </table>
        <table cellpadding=2 cellspacing=2 align="center" style="border:1px solid black" width="200">
            <tr>
                <td>
                    <table cellpadding=0 cellspacing=0 align="center">
                        <tr>
                            <td align="right">&nbsp;<b>Login</b>&nbsp;</td>
                            <td>&nbsp;<input type="text" style="width:81" name="txtLogin">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;<b>Password</b>&nbsp;</td>
                            <td>&nbsp;<input type="password" style="width:81" name="txtPassword">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;<b>Año proceso</b>&nbsp;</td>
                            <td>
                                <table cellpadding=0 cellspacing=0>
                                    <tr>
                                        <td>
                                            &nbsp;<select name="cmbAno">
                                            <?
                                                for($x=date("Y");$x>2005;$x--){
                                                    echo "<option value='".trim($x)."'>".trim($x)."</option>";
                                                }
                                            ?>
                                            </select>
                                        </td>
                                        <td><input type="submit" value="Entrar">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</body>
