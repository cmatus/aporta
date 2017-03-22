<div id="overDiv" style="position:absolute;z-index:2"><marquee align='middle' class='texto' direction='left' width='300' id='m1' scrolldelay='35'></marquee></div>
<?include("menu.inc")?>
<script language="JavaScript" type="text/JavaScript" src="http://www.stein.cl/SLI/Include/funciones.js"></script>
<body name="theBody" id="theBody">
    <form name="thisform" action="CorreccionMonetaria.php" method="post">
        <table cellpadding=2 cellspacing=2>
            <tr>
                <td>
                <?php
                    
                    include("../SLI/SLIStandar/conexion.php");
                    
                    $lsAno = $HTTP_GET_VARS["ANO"];
                    $lsAno = 2006;
                    
                    $lsSQL = "
                        SELECT	MON.desc_moneda  [Moneda],
                                MON.id_moneda    [Cod.],
                                PAR.semestral    [Semestral],
                                PAR.anual        [Anual]
                        FROM	DOCUMENTOS..par_cm_variacion PAR INNER JOIN SLI..monedas MON ON PAR.id_moneda = MON.id_moneda
                        WHERE	ano = 2006";
                    
                	$msresults = mssql_query($lsSQL); 
                	$msfields  = mssql_num_fields($msresults); 
                	$msrows    = mssql_num_rows($msresults);
                    
                	$lsCampo = array();
                	
                	$lsCampo[0][0]  = "left";
                	$lsCampo[0][1]  = "left";
                	$lsCampo[0][2]  = "right";
                    $lsCampo[0][3]  = "right";
                    	
                    $lsCampo[1][0]  = 180;  //Articulo
                    $lsCampo[1][1]  = 40;  //Planta
                    $lsCampo[1][2]  = 50;  //Procedencia
                    $lsCampo[1][3]  = 50;  //Cod. Prov.
                    
                    echo "<table cellpadding=0 cellspacing=0><tr><td><b><font size=4>Costo de Reposición de Mercaderías Internacionales</font></b></td></tr></table><br>";
                	$lsTitulo = "<table cellpadding=0 cellspacing=0 style='border-collapse:collapse' border=1>";
                    $lsTitulo = $lsTitulo."<tr bgcolor='#e0e0e0' height=20>";
                	for($x=0;$x<$msfields;$x++){
                		$lsCelda = mssql_fetch_field($msresults,$x);
                		$lsTitulo = $lsTitulo."<td nowrap align='center'>&nbsp;<b>".trim($lsCelda->name)."</b>&nbsp;</td>";
                	}
                    $lsTitulo = $lsTitulo."</tr>";
                    echo $lsTitulo;
                    
                	$liNum = 1;
                	while($row = mssql_fetch_array($msresults)){
                        $lsFila = "<tr height=20>";
                		for($x=0;$x<$msfields;$x++){            
                			$lsCelda = mssql_fetch_field($msresults,$x);
                			$lsFila = $lsFila."<td nowrap align='".$lsCampo[0][$x]."' width='".$lsCampo[1][$x]."'>&nbsp;".trim($row[$lsCelda->name])."&nbsp;</td>";
                		}
                		$liNum++;
                		$lsFila = $lsFila."</tr>";
                		echo $lsFila;
                		
                	}
                	
                	echo "</table>";
                	
                ?>
                </td>
                <td valign="top">
                    <table cellpadding=2 cellspacing=2><tr><td><b><font size=4>Costo de Reposición de Mercaderías Nacionales</font></b></td></tr></table><br>
                    <table cellpadding=2 cellspacing=2>   
                        <tr><td style="text-align:justify">Con adquisiciones en el segundo semestre del año 2006 de bienes de su mismo género, calidad o características, el costo de reposición tributario será el precio más alto convenido por dichos bienes durante el año 2006.</td></tr>  
                        <tr><td style="text-align:justify">En cambio, si existen sólo adquisiciones en el primer semestre del año 2006, será el precio más alto convenido en dicho semestre, reajustado en un 1,0%.</td></tr>
                        <tr><td style="text-align:justify">Por el contrario, si no existen adquisiciones en el año 2006, el valor de libros al término del ejercicio anterior se debe reajustar en un 2,1%.</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</body>
