<?php
    setcookie("cook_log","",mktime(0,0,0,3,1,1989));
    setcookie("cook_nom","",mktime(0,0,0,3,1,1989));
    setcookie("cook_rol","",mktime(0,0,0,3,1,1989));
?>
<body>
    <form method="post" name="thisform" runat="server" action="login.php?ACC=LOGIN">
        <table style="border:1px solid silver;width:400px" align="center">
            <tr height=20><td style="background-Color:#5b7d9b;text-align:center;font:normal normal 10pt tahoma,arial,helvetica,sans-serif;color:white"><b>Cierre de Sesi&oacute;n</b></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;&nbsp;&nbsp;<img src="images/mainlogo_full.gif" /></td></tr>
                <td align="center">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align:right;font:bold bold 10pt tahoma,arial,helvetica,sans-serif">&nbsp;Se ha cerrado la sesión&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
        </table>
    </form>
</body>
</html>
