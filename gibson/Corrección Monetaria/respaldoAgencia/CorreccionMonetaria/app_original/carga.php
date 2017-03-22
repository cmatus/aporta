<?php
    
    $dbh = mssql_connect("jupiter","sis_sli","sliusr") or die ('I cannot connect to the database because: ' . mssql_error());
    mssql_select_db("personalizados");
    set_time_limit(0);
    
    include("createzip.php");
    
    /*
    $lsSQL = "personalizados..[sp907610004_cmm_ppp] @ano = '2008', @planta = 'CL00'";
    if(mssql_query($lsSQL)){echo "CL00<br>";}             
    $lsSQL = "personalizados..[sp907610004_cmm_ppp] @ano = '2008', @planta = 'CL10'";
    if(mssql_query($lsSQL)){echo "CL10<br>";}              
    $lsSQL = "personalizados..[sp907610004_cmm_ppp] @ano = '2008', @planta = 'CL11'";
    if(mssql_query($lsSQL)){echo "CL11<br>";}
    $lsSQL = "personalizados..[sp907610004_cmm_ppp] @ano = '2008', @planta = 'CL1V'";
    if(mssql_query($lsSQL)){echo "CL1V<br>";}
    $lsSQL = "personalizados..[sp907610004_cmm_ppp] @ano = '2008', @planta = 'CL70'";
    if(mssql_query($lsSQL)){echo "CL70<br>";}
    $lsSQL = "personalizados..[sp907610004_cmm_ppp] @ano = '2008', @planta = 'CL71'";
    if(mssql_query($lsSQL)){echo "CL71<br>";}
    $lsSQL = "personalizados..[sp907610004_cmm_ppp] @ano = '2008', @planta = 'CL7V'";
    if(mssql_query($lsSQL)){echo "CL7V<br>";}
    $lsSQL = "personalizados..[sp907610004_cmm_ppp] @ano = '2008', @planta = 'CL90'";
    if(mssql_query($lsSQL)){echo "CL90<br>";}
    */
    
    $sentido[1] = "CL00";
    $sentido[2] = "CL10";
    $sentido[3] = "CL11";
    $sentido[4] = "CL1V";
    $sentido[5] = "CL70"; 
    $sentido[6] = "CL71";
    $sentido[7] = "CL7V";
    $sentido[8] = "CL90";
    
    for($y=1;$y<=8;$y++){
      
      $lsAno = "2008";
      $lsPlanta = $sentido[$y];
      
      /*
      $lsSQL = "personalizados..[sp907610004_cmm_calculacostos] @ano = '".trim($lsAno)."', @planta = '".$lsPlanta."'";
      mssql_query($lsSQL);
      
      $lsSQL = "personalizados..[sp907610004_cmm_SaldoMensual] @ano = '".trim($lsAno)."', @planta = '".$lsPlanta."'";
      mssql_query($lsSQL);
      
      $lsSQL = "personalizados..[sp907610004_cmm_ppp] @planta = '".$lsPlanta."', @ano = '".trim($lsAno)."'";
      mssql_query($lsSQL);
      
      $lsAnterior = "";
      $lsAcumulado = 0;
      $lsPPP_Ant = 0;
      $lsSQL = "select id,mes,planta,articulo,mov_tipo,cantidad,saldo,costo,sli_total,ppp,ppp_acumulado from [907610004_cmm_LibroExistencias] WHERE planta = '".$lsPlanta."' AND LEFT(mes,4) = '".$lsAno."' order by planta,articulo,mes,docto_fec,mov_tipo,id";
      $result = mssql_query($lsSQL);
      
      while($row = mssql_fetch_array($result)){
          
          if($lsAnterior!=$row["planta"]."@".$row["articulo"]&&$lsAnterior!=""&&$lsAnt_Mes!=$row["mes"]){
              if(trim($lsPPP_Ant)==""){
                  $lsPPP_Ant = 0;
              }
              $lsSQL = "
          		UPDATE	[907610004_cmm_saldosfinales]
          		SET		ppp = ".$lsPPP_Ant.",
          				ppp_acumulado = ".$lsAcumulado."
          		WHERE	articulo = '".$lsAnt_Articulo."' AND
          				planta = '".$lsAnt_Planta."' AND
          				mes = '".$lsAnt_Mes."'";
          		mssql_query($lsSQL);
          }
          
          if($lsAnterior!=$row["planta"]."@".$row["articulo"]){
              if($row["mov_tipo"]=="101"){
                  $lsAcumulado = $row["sli_total"] * $row["saldo"];
              } else{
                  $lsAcumulado = $row["ppp"]*$row["saldo"];
              }
          } else{
              if($row["mov_tipo"]=="101"){
                  $lsAcumulado = $lsAcumulado + $row["sli_total"] * $row["cantidad"];
              } else{
                  $lsAcumulado = $lsAcumulado + $lsPPP_Ant * $row["cantidad"];
              } 
          }
          if($row["saldo"]==0){
              $lsPPP = $lsPPP_Ant;
          } else{
              $lsPPP = $lsAcumulado / $row["saldo"];
          }
          $lsPPP_Ant = $lsPPP;
          
          $lsSQL = "UPDATE [907610004_cmm_LibroExistencias] SET ppp = ".number_format($lsPPP,0,"","").", ppp_acumulado = ".number_format($lsAcumulado,0,"","")." WHERE id = ".trim($row["id"]);
          mssql_query($lsSQL);
          
          $lsAnterior = $row["planta"]."@".$row["articulo"];
          $lsAnt_Planta   = $row["planta"];
          $lsAnt_Articulo = $row["articulo"];
          $lsAnt_Mes = $row["mes"];
          
      }
        
      $lsSQL = "
      DECLARE @planta  VARCHAR(4)
      DECLARE @ano     VARCHAR(4)
      DECLARE	@ano_ant VARCHAR(4)
      
      SET   @planta  = '".$lsPlanta."'
      SET   @ano     = '".$lsAno."'
      SET		@ano_ant = RTRIM(LTRIM(YEAR(DATEADD(YEAR,-1,CONVERT(SMALLDATETIME,@ano + '0101',112)))))
      
      UPDATE [907610004_cmm_LibroExistencias] SET ppp = costo WHERE ISNULL(ppp,0) = 0 AND planta = @planta
      
      UPDATE	[907610004_cmm_saldosfinales]
      SET		sli_total     = 0,
      		ppp           = 0,
      		ppp_acumulado = 0,
      		costo         = 0
      WHERE	planta = @planta AND
      		mes = @ano + '12'
      
      create table #tmp_libro_falta(
      num				int IDENTITY(1,1),
      id				int	          NULL,
      planta			varchar(4)    NULL,
      articulo		varchar(20)   NULL,
      sli_total		numeric(15,0) NULL,
      ppp				numeric(15,0) NULL,
      ppp_acumulado	numeric(15,0) NULL)
      
      insert	into #tmp_libro_falta
      select	id,
      		planta,
      		articulo,
      		sli_total,
      		ppp,
      		ppp_acumulado
      from	[907610004_cmm_libroexistencias]
      where	planta = @planta
      order	by
      		planta,
      		articulo,
      		mes,
      		docto_fec,
      		mov_tipo,
      		id
      
      select	planta,
      		articulo,
      		max(num) num
      into	#tmp_sli_total
      from	#tmp_libro_falta
      where	sli_total <> 0
      group	by
      		planta,
      		articulo
      
      select	planta,
      		articulo,
      		max(num) num
      into	#tmp_ppp
      from	#tmp_libro_falta
      where	ppp <> 0
      group	by
      		planta,
      		articulo
      
      select	planta,
      		articulo,
      		max(num) num
      into	#tmp_ppp_acumulado
      from	#tmp_libro_falta
      where	ppp_acumulado <> 0
      group	by
      		planta,
      		articulo
      
      SELECT	TM1.planta,
      		TM1.articulo,
      		TM1.sli_total
      INTO	#tmp_sli_total_2
      FROM	#tmp_libro_falta TM1 INNER JOIN #tmp_sli_total TM2 ON TM1.num = TM2.num
      
      SELECT	TM1.planta,
      		TM1.articulo,
      		TM1.ppp
      INTO	#tmp_ppp_2
      FROM	#tmp_libro_falta TM1 INNER JOIN #tmp_ppp TM2 ON TM1.num = TM2.num
      
      SELECT	TM1.planta,
      		TM1.articulo,
      		TM1.ppp_acumulado
      INTO	#tmp_ppp_acumulado_2
      FROM	#tmp_libro_falta TM1 INNER JOIN #tmp_ppp_acumulado TM2 ON TM1.num = TM2.num
      
      UPDATE	[907610004_cmm_saldosfinales]
      SET		[907610004_cmm_saldosfinales].sli_total = TMP.sli_total
      FROM	[907610004_cmm_saldosfinales] FIN INNER JOIN #tmp_sli_total_2 TMP ON FIN.planta = TMP.planta AND FIN.articulo = TMP.articulo
      WHERE	FIN.mes = @ano + '12'
      
      UPDATE	[907610004_cmm_saldosfinales]
      SET		[907610004_cmm_saldosfinales].ppp = TMP.ppp
      FROM	[907610004_cmm_saldosfinales] FIN INNER JOIN #tmp_ppp_2 TMP ON FIN.planta = TMP.planta AND FIN.articulo = TMP.articulo
      WHERE	FIN.mes = @ano + '12'
      
      UPDATE	[907610004_cmm_saldosfinales]
      SET		[907610004_cmm_saldosfinales].ppp_acumulado = TMP.ppp_acumulado
      FROM	[907610004_cmm_saldosfinales] FIN INNER JOIN #tmp_ppp_acumulado_2 TMP ON FIN.planta = TMP.planta AND FIN.articulo = TMP.articulo
      WHERE	FIN.mes = @ano + '12'
      
      DROP TABLE #tmp_sli_total
      DROP TABLE #tmp_sli_total_2
      DROP TABLE #tmp_ppp
      DROP TABLE #tmp_ppp_2
      DROP TABLE #tmp_ppp_acumulado
      DROP TABLE #tmp_ppp_acumulado_2
      DROP TABLE #tmp_libro_falta
      
      UPDATE	[907610004_cmm_saldosfinales]
      SET		ppp_acumulado = costo * saldo,
      		sli_total     = costo
      WHERE	mes = @ano + '12' AND
              planta = @planta and
      		ISNULL(ppp_acumulado,0) = 0 and
      		isnull(saldo,0) <> 0
              
      UPDATE  [907610004_cmm_saldosfinales]
      SET     costo = CONVERT(NUMERIC(15,0),valor/saldo)
      WHERE   mes = @ano + '12' AND
              planta = @planta and
              ISNULL(saldo,0) <> 0
              
      UPDATE  [907610004_cmm_saldosfinales]
      SET     costo = 0,
              sli_total = 0,
              valor = 0,
              ppp_acumulado = 0
      WHERE   mes = @ano + '12' AND
              ISNULL(saldo,0) = 0 AND
              planta = @planta
      
      update	[907610004_cmm_saldosfinales]
      set		[907610004_cmm_saldosfinales].ppp = FIN.costo,
      		[907610004_cmm_saldosfinales].ppp_acumulado = FIN.saldo * FIN.costo
      from	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_libroexistencias] LIB ON FIN.planta = LIB.planta AND FIN.articulo = LIB.articulo
      where	FIN.mes = @ano + '12' AND
      		FIN.planta = @planta AND
      		LIB.articulo IS NULL
      
      UPDATE	[907610004_cmm_saldosfinales]
      SET		[907610004_cmm_saldosfinales].ppp_acumulado = FIN.ppp * FIN.saldo
      from	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_libroexistencias] LIB ON FIN.planta = LIB.planta AND FIN.articulo = LIB.articulo AND LEFT(LIB.mes,4) = @ano + '12'
      where	FIN.mes = @ano + '12' AND
      		FIN.saldo <> 0 AND
      		FIN.planta = @planta AND
      		FIN.ppp_acumulado <> FIN.ppp * FIN.saldo AND
      		LIB.articulo IS NULL
      
      UPDATE	[907610004_cmm_saldosiniciales]
      SET		[907610004_cmm_saldosiniciales].ppp_acumulado = FIN.ppp_acumulado
      FROM	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_saldosiniciales] INI ON FIN.planta = INI.planta AND FIN.articulo = INI.articulo AND CONVERT(CHAR(6),DATEADD(MONTH,1,CONVERT(SMALLDATETIME,FIN.mes + '01',112)),112) = INI.mes
      WHERE	ISNULL(INI.ppp_acumulado,0) <> ISNULL(FIN.ppp_acumulado,0) AND
      		FIN.planta = @planta AND
      		ISNULL(FIN.saldo,0) <> 0
      
      UPDATE	[907610004_cmm_saldosiniciales]
      SET		[907610004_cmm_saldosiniciales].valor = FIN.valor
      FROM	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_saldosiniciales] INI ON FIN.planta = INI.planta AND FIN.articulo = INI.articulo AND CONVERT(CHAR(6),DATEADD(MONTH,1,CONVERT(SMALLDATETIME,FIN.mes + '01',112)),112) = INI.mes
      WHERE	ISNULL(INI.valor,0) <> ISNULL(FIN.valor,0) AND
      		FIN.planta = @planta AND
      		ISNULL(FIN.saldo,0) <> 0
      
      UPDATE	[907610004_cmm_saldosiniciales]
      SET		[907610004_cmm_saldosiniciales].ppp = FIN.ppp
      FROM	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_saldosiniciales] INI ON FIN.planta = INI.planta AND FIN.articulo = INI.articulo AND CONVERT(CHAR(6),DATEADD(MONTH,1,CONVERT(SMALLDATETIME,FIN.mes + '01',112)),112) = INI.mes
      WHERE	ISNULL(INI.ppp,0) <> ISNULL(FIN.ppp,0) AND
      		FIN.planta = @planta AND
      		ISNULL(FIN.saldo,0) <> 0
      
      UPDATE	[907610004_cmm_saldosiniciales]
      SET		[907610004_cmm_saldosiniciales].ppp = FIN.ppp
      FROM	[907610004_cmm_saldosfinales] FIN INNER JOIN      [907610004_cmm_saldosiniciales]  INI ON FIN.planta = INI.planta AND FIN.articulo = INI.articulo AND FIN.mes = INI.mes
      		                                  LEFT OUTER JOIN [907610004_cmm_libroexistencias] LIB ON FIN.planta = LIB.planta AND FIN.articulo = LIB.articulo AND FIN.mes = LIB.mes
      WHERE	ISNULL(INI.ppp,0) <> ISNULL(FIN.ppp,0) AND
      		FIN.planta = @planta AND
      		ISNULL(FIN.saldo,0) <> 0 AND
      		LIB.articulo IS NULL AND
      		FIN.mes = @ano + '12'
      
      UPDATE	[907610004_cmm_saldosiniciales]
      SET		[907610004_cmm_saldosiniciales].ppp_acumulado = FIN.ppp_acumulado
      FROM	[907610004_cmm_saldosfinales] FIN INNER JOIN      [907610004_cmm_saldosiniciales]  INI ON FIN.planta = INI.planta AND FIN.articulo = INI.articulo AND FIN.mes = INI.mes
      		                                  LEFT OUTER JOIN [907610004_cmm_libroexistencias] LIB ON FIN.planta = LIB.planta AND FIN.articulo = LIB.articulo AND FIN.mes = LIB.mes
      WHERE	ISNULL(INI.ppp_acumulado,0) <> ISNULL(FIN.ppp_acumulado,0) AND
      		FIN.planta = @planta AND
      		ISNULL(FIN.saldo,0) <> 0 AND
      		LIB.articulo IS NULL AND
      		FIN.mes = @ano + '12'
      
      UPDATE	[907610004_cmm_saldosiniciales]
      SET		[907610004_cmm_saldosiniciales].valor = FIN.valor
      FROM	[907610004_cmm_saldosfinales] FIN INNER JOIN      [907610004_cmm_saldosiniciales]  INI ON FIN.planta = INI.planta AND FIN.articulo = INI.articulo AND FIN.mes = INI.mes
      		                                  LEFT OUTER JOIN [907610004_cmm_libroexistencias] LIB ON FIN.planta = LIB.planta AND FIN.articulo = LIB.articulo AND FIN.mes = LIB.mes
      WHERE	ISNULL(INI.valor,0) <> ISNULL(FIN.valor,0) AND
      		FIN.planta = @planta AND
      		ISNULL(FIN.saldo,0) <> 0 AND
      		LIB.articulo IS NULL AND
      		FIN.mes = @ano + '12'";
      mssql_query($lsSQL);
      */
      
      for($x=1;$x<=12;$x++){
          
          $lsMes = "00".trim($x);
          $lsMes = substr($lsMes,strlen($lsMes)-2,2);
          
          $lsSQL = "sp907610004_cmm_libroexistencias @planta = '".$lsPlanta."', @mes = '".$lsAno.$lsMes."', @resumen = 0";
          $result = mssql_query($lsSQL);
          
          $lsArc_Libro = "LibroExistencias_".$lsAno.$lsMes."_".$lsPlanta."_xls";
          
          if(trim($x)=="1"){
              $handle = fopen($lsArc_Libro.".xls","w");
          } else{
              $handle = fopen($lsArc_Libro.".xls","w");
          }
          fwrite($handle,"<table cellpadding=0 cellspacing=0>");
          
          $lsLinea = "
          <tr>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Planta</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Artículo</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Bodega</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Cantidad</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Saldo</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Unidad</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Moneda</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Costo (SAP)</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Costo (SLI)</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Costo (PPP)</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Total (SAP)</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Total (SLI)</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Total (PPP)</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Cod. Mov.</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Movimiento</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Documento</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Mes</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Fecha</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Referencia</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Cod. Prov.</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>Proveedor</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:0px solid black;border-left:1px solid black'>&nbsp;<b>P/O</b>&nbsp;</td>
          <td bgcolor='silver' align='center' style='border-top:1px solid black;border-right:1px solid black;border-left:1px solid black'>&nbsp;<b>Embarque</b>&nbsp;</td>
          </tr>";
          fwrite($handle,$lsLinea);
          
          $liCount = 0;
          while($row = mssql_fetch_array($result)){
                                  
              switch(trim($row["tipo"])){
                  case "1":
                      if(trim($row["mov_desc"])=="SALDO INICIAL"||trim($row["mov_desc"])=="SALDO FINAL"){
                          $lsColor = "#ffff99";
                      } else{
                          $lsColor = "white";
                      }
                      break;
                  case "2":
                      $lsColor = "#ccffff";
                      break;                         
              }
              
              $lsBorde = "";
              $lsColor = "white";
              
              if(trim($row["mov_desc"])=="SALDO INICIAL"){
                  $lsBorde = ";border-top:1px solid black";
                  $lsColor = "lime";
              } elseif(trim($row["mov_desc"])=="SALDO FINAL"){
                  $lsBorde = ";border-bottom:1px solid black";
                  $lsColor = "lime";
              }
              
              if(trim($row["tipo"])=="2"){
                  $lsLinea = "
                  <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["cantidad"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["saldo"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["unidad"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["moneda"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["costo"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["sli_total"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["ppp"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["valor"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["sli_total"]*$row["cantidad"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["ppp_acumulado"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["mov_tipo"])."</td>
                  <td style='border-right:1px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["mov_desc"])."</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>";
              } else{
                  $lsLinea = "
                  <tr>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".$lsPlanta."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["articulo"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["bodega"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["cantidad"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["saldo"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["unidad"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["moneda"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["costo"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["sli_total"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["ppp"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["valor"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["sli_total"]*$row["cantidad"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["ppp_acumulado"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["mov_tipo"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["mov_desc"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["docto_num"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["mes"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='center'>".trim($row["docto_fec"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["referencia"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["cod_proveedor"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."'>".trim($row["proveedor"])."</td>
                  <td style='border-right:0px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["po"])."</td>
                  <td style='border-right:1px solid black;border-left:1px solid black".$lsBorde."' bgcolor='".$lsColor."' align='right'>".trim($row["embarque"])."</td>
                  </tr>";
              }
              fwrite($handle,$lsLinea);
              $liCount++;
              $lsAnterior = trim($row["articulo"]);
              
          }
          fwrite($handle,"</table>");
          fclose($handle);
          
          $cont = array($lsArc_Libro.".xls"=> file_get_contents($lsArc_Libro.".xls"));
          createzip($cont,$lsArc_Libro.".zip") or die("Error: al construir el ZIP.");
          unlink($lsArc_Libro.".xls");
      
      }
      
      /*
      $lsSQL = "sp907610004_cmm_librocompras @planta = '".$lsPlanta."', @ano = '".$lsAno."'";
      $result = mssql_query($lsSQL);
      
      $lsSQL = "sp907610004_cmm_correccionmonetaria @planta = '".$lsPlanta."', @ano = '".$lsAno."'";
      $result = mssql_query($lsSQL);
      */
      echo $sentido[$y]."<br>";
      
    }
    
?>
