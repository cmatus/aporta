<?php
    include("../conexion.php");
?>
<div id="overDiv" style="position:absolute;z-index:2"><marquee align='middle' class='texto' direction='left' width='300' id='m1' scrolldelay='35'></marquee></div>
<?include("menu.inc")?>
<script language="JavaScript" type="text/JavaScript" src="http://www.stein.cl/SLI/Include/funciones.js"></script>
<script>
    function CorreccionMonetaria(){
        if((xmlhttp.readyState==4)){
            document.all("theExcel").innerHTML = "&nbsp;<a href='CorreccionMonetaria.xls' target='_blank'><img title='Exportar a Excel' border=0 src='../sli/slistandar/images/excel.gif'></a>&nbsp;";
            document.all("theExplorer").innerHTML = "&nbsp;<a href='CorreccionMonetaria.htm' target='_blank'><img title='Versión HTML' border=0 src='images/ie.gif'></a>&nbsp;";
            document.all("thePDF").innerHTML = "&nbsp;<a href='CorreccionMonetaria_PDF.php?ANO=" + document.thisform.cmbAno.value + "' target='_blank'><img title='Versión PDF' border=0 src='images/pdf.gif'></a>&nbsp;";
            Procesando(0,theBody);
        }
    }
</script>
<body name="theBody" id="theBody">
    <form name="thisform" action="CorreccionMonetaria.php" method="post">
        <table cellpadding=0 cellspacing=0>
            <tr height=30><td><b><font size=4>Corrección Monetaria</font></b></td></tr>
            <tr>
                <td>
                    <table cellpadding=0 cellspacing=0 border=1 style='border-collapse:collapse'>
                        <tr height=35>
                          	<td bgcolor='#f3f3f3'>&nbsp;<b>Mes</b>&nbsp;</td>
                            <td>&nbsp;<select name="cmbAno"><option value="2006">2006</option></select>&nbsp;</td>
                            <td bgcolor='#f3f3f3'>&nbsp;<input type='button' value='Buscar' onclick="Procesando(1,theBody);GeneraObjeto('CorreccionMonetaria','CorreccionMonetaria_Dat.php?ANO=' + document.thisform.cmbAno.options[document.thisform.cmbAno.selectedIndex].value)">&nbsp;</td>
                            <td bgcolor='#EDEDED' align='center' name="theExcel"    id="theExcel"></td>
                            <td bgcolor='#EDEDED' align='center' name="theExplorer" id="theExplorer"></td>
                            <td bgcolor='#EDEDED' align='center' name="thePDF"      id="thePDF"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</body>
