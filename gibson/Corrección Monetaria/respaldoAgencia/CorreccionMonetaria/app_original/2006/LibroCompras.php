<?php
    include("../conexion.php");
?>
<div id="overDiv" style="position:absolute;z-index:2"><marquee align='middle' class='texto' direction='left' width='300' id='m1' scrolldelay='35'></marquee></div>
<?include("menu.inc")?>
<script language="JavaScript" type="text/JavaScript" src="http://www.stein.cl/SLI/Include/funciones.js"></script>
<script>
    function LibroCompras(){
        if((xmlhttp.readyState==4)){
            document.all("theExcel").innerHTML = "&nbsp;<a href='LibroCompras.xls' target='_blank'><img title='Exportar a Excel' border=0 src='../sli/slistandar/images/excel.gif'></a>&nbsp;";
            document.all("theExplorer").innerHTML = "&nbsp;<a href='LibroCompras.htm' target='_blank'><img title='Versión HTML' border=0 src='images/ie.gif'></a>&nbsp;";
            document.all("thePDF").innerHTML = "&nbsp;<a href='LibroCompras.pdf' target='_blank'><img title='Versión PDF' border=0 src='images/pdf.gif'></a>&nbsp;";
            Procesando(0,theBody);
        }
    }
</script>
<body name="theBody" id="theBody">
    <form name="thisform" action="LibroCompras.php" method="post">
        <table cellpadding=0 cellspacing=0>
            <tr height=30><td><b><font size=4>Libro de Compras</font></b></td></tr>
            <tr>
                <td>
                    <table cellpadding=0 cellspacing=0 border=1 style='border-collapse:collapse'>
                        <tr height=35>
                            <td bgcolor='#f3f3f3'>&nbsp;<b>Planta</b>&nbsp;</td>
                            <td>&nbsp;<select style='width:70' name='cmbPlanta'>
                            <?php
                                $lsPlanta = $HTTP_POST_VARS["cmbPlanta"];
                                $lsMes    = $HTTP_POST_VARS["cmbMes"];
                                
                                $laPlanta = Array();
                                
                                $laPlanta[0][1] = "CL00";
                                $laPlanta[0][1] = "CL10";
                                $laPlanta[0][2] = "CL11";
                                $laPlanta[0][3] = "CL70";
                                $laPlanta[0][4] = "CL71";        
                                $laPlanta[0][5] = "CL7V";
                                $laPlanta[0][6] = "CL90";
                                $laPlanta[0][7] = "";
                        
                                $laPlanta[1][0] = "CL00";
                                $laPlanta[1][1] = "CL10";
                                $laPlanta[1][2] = "CL11";
                                $laPlanta[1][3] = "CL70";
                                $laPlanta[1][4] = "CL71";        
                                $laPlanta[1][5] = "CL7V";
                                $laPlanta[1][6] = "CL90";
                                $laPlanta[1][7] = ":: TODAS ::";
                                
                                for($x=0;$x<count($laPlanta[0]);$x++){
                                  $lsSEL = "";
                                  if($lsPlanta==$laPlanta[$x]){
                                    $lsSEL = " SELECTED ";
                                  }
                                  echo "<option ".$lsSEL." value='".$laPlanta[0][$x]."'>".$laPlanta[1][$x]."</option>";
                                }
                            ?>
                            </select>&nbsp;</td>
                          	<td bgcolor='#f3f3f3'>&nbsp;<b>Mes</b>&nbsp;</td>
                            <td>&nbsp;<select style='width:150' name='cmbMes'>
                            <?php
                                
                                $laMes = Array();
                        
                                $laMes[0][0] = "200601";
                                $laMes[1][0] = "200602";
                                $laMes[2][0] = "200603";
                                $laMes[3][0] = "200604";
                                $laMes[4][0] = "200605";
                                $laMes[5][0] = "200606";
                                $laMes[6][0] = "200607";
                                $laMes[7][0] = "200608";
                                $laMes[8][0] = "200609";
                                $laMes[9][0] = "200610";
                                $laMes[10][0] = "200611";
                                $laMes[11][0] = "200612";
                                $laMes[12][0] = "";
                                
                                $laMes[0][1] = "2006 - ENERO";
                                $laMes[1][1] = "2006 - FEBRERO";
                                $laMes[2][1] = "2006 - MARZO";
                                $laMes[3][1] = "2006 - ABRIL";
                                $laMes[4][1] = "2006 - MAYO";
                                $laMes[5][1] = "2006 - JUNIO";
                                $laMes[6][1] = "2006 - JULIO";
                                $laMes[7][1] = "2006 - AGOSTO";
                                $laMes[8][1] = "2006 - SEPTIEMBRE";
                                $laMes[9][1] = "2006 - OCTUBRE";
                                $laMes[10][1] = "2006 - NOVIEMBRE";
                                $laMes[11][1] = "2006 - DICIEMBRE";
                                $laMes[12][1] = ":: TODO 2006 ::";
                                
                                for($x=0;$x<count($laMes);$x++){
                                  $lsSEL = "";
                                  if($lsMes==$laMes[$x][0]){
                                    $lsSEL = " SELECTED ";
                                  }
                                  echo "<option ".$lsSEL." value='".$laMes[$x][0]."'>".$laMes[$x][1]."</option>";
                                }
                            ?>
                            </select>&nbsp;</td>
                            <td bgcolor='#f3f3f3'>&nbsp;<input type='button' value='Buscar' onclick="Procesando(1,theBody);GeneraObjeto('LibroCompras','LibroCompras_Dat.php?PLA=' + document.thisform.cmbPlanta.options[document.thisform.cmbPlanta.selectedIndex].value + '&MES=' + document.thisform.cmbMes.options[document.thisform.cmbMes.selectedIndex].value)">&nbsp;</td>
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
