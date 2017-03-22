<?php
    
    include("seguridad.php");
    
    $lsSQL = "
        SELECT  id,
                articulo,
                planta,
                bodega,
                cantidad,
                unidad,
                valor,
                moneda,
                costo,
                mov_tipo,
                mov_desc,
                mov_reg,
                docto_num,
                CONVERT(CHAR(10),docto_fec,103) fecha,
                CONVERT(CHAR(6),docto_fec,112)  mes,
                referencia,
                proveedor
        FROM    libroexistencias_carga
        ORDER   BY
                planta,
                articulo,
                docto_fec,
                mov_tipo";
	$result = mssql_query($lsSQL);
	
	$liAnterior_Planta    = "";
	$liAnterior_Articulo  = "";
	$liAnterior_Mes       = "";
	$liAnterior_Fecha     = "";
	
	$liSum_Cantidad = 0;
	$liSum_Valor    = 0;
	
	echo "<table border=1>";
	while($row = mssql_fetch_array($result)){
        
        /*
    	if($liAnterior_Mes!=trim($row["docto_mes"])||$liAnterior_Planta!=trim($row["planta"])||$liAnterior_Articulo!=trim($row["articulo"])){
            
            if($liAnterior_Mes!=""){
                
                $lsSQL = "
                    INSERT  INTO LibroExistencias_Saldos(
                            articulo,
                            planta,
                            cantidad,
                            unidad,
                            valor,
                            moneda,
                            costo,
                            mov_tipo,
                            mov_desc,
                            docto_fec)
                    VALUES('".$liAnterior_Articulo."',
                           '".$liAnterior_Planta."',
                           '".$liSum_Cantidad."',
                           '',
                           '".$liSum_Valor."',
                           '',
                           '',
                           'ZZZ',
                           'SALDO FINAL',
                           DATEADD(DAY,-1,DATEADD(MONTH,1,CONVERT(SMALLDATETIME,'".$liAnterior_Mes."' + '01',103))))";
                mssql_query($lsSQL);
                
            }
            
            $lsSQL = "
                INSERT  INTO LibroExistencias_Saldos(
                        articulo,
                        planta,
                        cantidad,
                        unidad,
                        valor,
                        moneda,
                        costo,
                        mov_tipo,
                        mov_desc,
                        docto_fec)
                VALUES('".$liAnterior_Articulo."',
                       '".$liAnterior_Planta."',
                       '".$liSum_Cantidad."',
                       '',
                       '".$liSum_Valor."',
                       '',
                       '',
                       '000',
                       'SALDO INICIAL',
                       CONVERT(SMALLDATETIME,'".trim($row["docto_mes"])."01',103))";
            if(!mssql_query($lsSQL)){
                echo $lsSQL."<br>";
            }
            
            if($liAnterior_Articulo!=trim($row["articulo"])){
            	$liSum_Cantidad = 0;
            	$liSum_Valor    = 0;
            }
            
        }
        */
        
        if($liAnterior_Planta!=trim($row["planta"])||$liAnterior_Articulo!=trim($row["articulo"])){
            $liSum_Cantidad = 0;
        }
        
        $liSum_Cantidad = $liSum_Cantidad + $row["cantidad"];
        $liSum_Valor    = $liSum_Valor    + ($row["cantidad"] * $row["costo"]);
        
        $lsSQL = "UPDATE libroexistencias_carga SET saldo = ".$liSum_Cantidad." WHERE id = ".$row["id"];
        if(!mssql_query($lsSQL)){
            echo $lsSQL."<br>";
        }
    	
    	$liAnterior_Planta   = trim($row["planta"]);
    	$liAnterior_Articulo = trim($row["articulo"]);
    	$liAnterior_Mes      = trim($row["docto_mes"]);
    	
	}
	
	/*
    $lsSQL = "
        INSERT  INTO LibroExistencias_Saldos(
                articulo,
                planta,
                cantidad,
                unidad,
                valor,
                moneda,
                costo,
                mov_tipo,
                mov_desc,
                docto_fec)
        VALUES('".$liAnterior_Articulo."',
               '".$liAnterior_Planta."',
               '".$liSum_Cantidad."',
               '',
               '".$liSum_Valor."',
               '',
               '',
               'ZZZ',
               'SALDO FINAL',
               DATEADD(DAY,-1,DATEADD(MONTH,1,CONVERT(SMALLDATETIME,'".$liAnterior_Mes."' + '01',103))))";
    mssql_query($lsSQL);
    */
	
?>
