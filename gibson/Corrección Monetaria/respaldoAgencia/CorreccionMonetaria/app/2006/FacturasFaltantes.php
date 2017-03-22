<div id="overDiv" style="position:absolute;z-index:2"><marquee align='middle' class='texto' direction='left' width='300' id='m1' scrolldelay='35'></marquee></div>
<?include("menu.inc")?>
<script language="JavaScript" type="text/JavaScript" src="http://www.stein.cl/SLI/Include/funciones.js"></script>
<body name="theBody" id="theBody">
    <form name="thisform" action="SaldoInicial.php" method="post">
        <table cellpadding=0 cellspacing=0>
            <tr height=30><td><b><font size=4>Facturas faltantes</font></b></td></tr>
            <tr>
                <td>
                <?php
                    
                    include("../SLI/SLIStandar/conexion.php");
                    
                    $lsAno = $HTTP_GET_VARS["ANO"];
                    $lsAno = 2006;
                    
                    $lsSQL = "DOCUMENTOS..spFacturasFaltantes";
                    
                	$msresults = mssql_query($lsSQL); 
                	$msfields  = mssql_num_fields($msresults); 
                	$msrows    = mssql_num_rows($msresults);
                    
                	$lsCampo = array();
                	
                	$lsCampo[0][0]  = "left";
                	$lsCampo[0][1]  = "left";
                	$lsCampo[0][2]  = "left";
                    $lsCampo[0][3]  = "left";
                    $lsCampo[0][4]  = "right";
                    $lsCampo[0][5]  = "right";
                    	
                    $lsCampo[1][0]  = 80;  // Articulo
                    $lsCampo[1][1]  = 50;  // Planta
                    $lsCampo[1][2]  = 50;  // U.M.
                    $lsCampo[1][3]  = 40;  // Costo
                    $lsCampo[1][4]  = 80;  // Valor
                    $lsCampo[1][5]  = 80;  // Saldo
                    
                	$lsTitulo = "<table cellpadding=0 cellspacing=0 style='border-collapse:collapse' border=1>";
                    $lsTitulo = $lsTitulo."<tr bgcolor='#e0e0e0' height=20>";
                    $lsTitulo = $lsTitulo."<td nowrap align='center'>&nbsp;<b>#</b>&nbsp;</td>";
                	for($x=0;$x<$msfields;$x++){
                		$lsCelda = mssql_fetch_field($msresults,$x);
                		$lsTitulo = $lsTitulo."<td nowrap align='center'>&nbsp;<b>".trim($lsCelda->name)."</b>&nbsp;</td>";
                	}
                    $lsTitulo = $lsTitulo."</tr>";
                    echo $lsTitulo;
                    
                	$liNum = 1;
                	while($row = mssql_fetch_array($msresults)){
                        $lsFila = "<tr>";
                        $lsFila = $lsFila."<td nowrap bgcolor='#e0e0e0' align='right'>&nbsp;<b>".trim($liNum)."</b>&nbsp;</td>";
                		for($x=0;$x<$msfields;$x++){            
                			$lsCelda = mssql_fetch_field($msresults,$x);
                            if($x>3){
                                $lsFila = $lsFila."<td nowrap align='".$lsCampo[0][$x]."' width='".$lsCampo[1][$x]."'>&nbsp;".number_format(trim($row[$lsCelda->name]),0)."&nbsp;</td>";
                            } else{
                                $lsFila = $lsFila."<td nowrap align='".$lsCampo[0][$x]."' width='".$lsCampo[1][$x]."'>&nbsp;".trim($row[$lsCelda->name])."&nbsp;</td>";
                            }
                		}
                		$liNum++;
                		$lsFila = $lsFila."</tr>";
                		echo $lsFila;
                		
                	}
                	
                	echo "</table>";
                	
                ?>
                </td>
            </tr>
        </table>
    </form>
</body>
