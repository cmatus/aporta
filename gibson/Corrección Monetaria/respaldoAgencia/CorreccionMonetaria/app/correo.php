<?php
    
    //$dbh = mssql_connect("jupiter","sis_sli","sliusr") or die ('I cannot connect to the database because: ' . mssql_error());
    //mssql_select_db("personalizados");
    
    $lsSQL = "
    DECLARE @planta  VARCHAR(4)
	DECLARE @ano     VARCHAR(4)
    DECLARE	@ano_ant VARCHAR(4)
    
    SET     @planta  = 'CL90'
    SET     @ano     = '2008'
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
    //mssql_query($lsSQL);
    
    //$laPag = split("/",$_SERVER['PHP_SELF']);
    //echo $laPag[1];
    
?>
