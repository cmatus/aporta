SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[spCorreccionMonetaria](
	@Tipo INT = NULL,
	@Ano  INT = NULL,
	@Art VARCHAR(20) = NULL,
	@Pla VARCHAR(20) = NULL
) AS

-- spCorreccionMonetaria @Ano = 2006

SET	NOCOUNT ON

IF(@Tipo IS NULL)
BEGIN

	SELECT	max(id) id
	INTO	#tmp_id
	FROM	libroexistencias
	GROUP	BY
			planta,
			articulo

	/* Carga de saldos iniciales según información enviada */

	SELECT	planta			 planta,
			articulo		 articulo,
			MAX(unidad)		 unidad,
			MAX(costo)		 costo,
			SUM(saldo)		 saldo,
			SUM(costo*saldo) valor,
			MAX(docto_fec)	 docto_fec
	INTO	#tmp_saldo_inicial
	FROM	SaldosIniciales
	GROUP	BY
			planta,
			articulo

	/* Tabla extracción saldo final y compras del año */

	CREATE	TABLE #tmp_1(
			num			  int IDENTITY(1,1),
			id			  int NULL,
			articulo	  varchar(25)	NULL,
			planta		  varchar(25)	NULL,
			procedencia	  varchar(3)    NULL,
			docto_num	  varchar(25)	NULL,
			docto_fec	  smalldatetime	NULL,
			po			  varchar(25)	NULL,
			referencia	  varchar(25)	NULL,
			unidad		  varchar(25)	NULL,
			saldo		  numeric(15,4)	NULL,
			sli_total	  numeric(15,0)	NULL,
			cod_proveedor varchar(25)	NULL,
			proveedor	  varchar(200)  NULL,
			id_moneda     varchar(3)    NULL)

	/* Tabla corrección monetaria */

	CREATE	TABLE #tmp_2(
			id			  int,
			articulo	  varchar(25)	NULL,
			planta		  varchar(25)	NULL,
			procedencia	  varchar(3)    NULL,
			docto_num	  varchar(25)	NULL,
			docto_fec	  smalldatetime	NULL,
			po			  varchar(25)	NULL,
			referencia	  varchar(25)	NULL,
			unidad		  varchar(25)	NULL,
			cantidad	  numeric(15,4)	NULL,
			acumulado	  numeric(15,4)	NULL,
			saldo		  numeric(15,4)	NULL,
			cod_proveedor varchar(25)	NULL,
			proveedor	  varchar(200)  NULL,
			sli_total	  numeric(15,0)	NULL, /* Costo unitario */
			costo_elegido numeric(15,0) NULL, /* Costo elegido */
			factor		  numeric(15,4) NULL, /* Factor corrección */
			id_moneda     varchar(3)    NULL)

	DECLARE	@id				int,
			@articulo		varchar(25),
			@planta			varchar(25),
			@procedencia	varchar(3),
			@docto_num		varchar(25),
			@docto_fec		smalldatetime,
			@po				varchar(25),
			@referencia		varchar(25),
			@unidad			varchar(25),
			@saldo			numeric(15,4),
			@sli_total		numeric(15,0),
			@cod_proveedor	varchar(25),
			@proveedor		varchar(200),
			@moneda			varchar(3)

	/* Fuision planta CL7V con CL70 */

	SELECT	LIB.id,
			LIB.articulo,
			LIB.planta,
			LIB.docto_num,
			LIB.docto_fec,
			LIB.po,
			LIB.referencia,
			LIB.unidad,
			LIB.saldo,
			LIB.sli_total
	INTO	#tmp_libroexistencias
	FROM	libroexistencias LIB INNER JOIN #tmp_id TMP ON LIB.id = TMP.id
	WHERE	LIB.saldo > 0

	UPDATE	#tmp_libroexistencias
	SET		id         = 0,
			docto_num  = '',
			docto_fec  = '19000101',
			planta     = 'CL70',
			po         = '',
			referencia = '',
			unidad     = 'PCE',
			sli_total  = 0
	WHERE	planta = 'CL7V'

	SELECT	MAX(id)			id,
			articulo		articulo,
			planta			planta,
			MAX(docto_num)	docto_num,
			MAX(docto_fec)	docto_fec,
			MAX(po)			po,
			MAX(referencia)	referencia,
			MAX(unidad)		unidad,
			SUM(saldo)		saldo,
			MAX(sli_total)	sli_total
	INTO	#tmp_libroexistencias_001
	FROM	#tmp_libroexistencias
	GROUP	BY
			articulo,
			planta

	/* Recorrido de saldos iniciales */

	DECLARE LibroCompras CURSOR FOR
	SELECT	id,
			articulo,
			planta,
			docto_num,
			docto_fec,
			po,
			referencia,
			unidad,
			saldo,
			sli_total
	FROM	#tmp_libroexistencias_001
	ORDER	BY
			planta,
			articulo

	/*
	SELECT	LIB.id,
			LIB.articulo,
			LIB.planta,
			LIB.docto_num,
			LIB.docto_fec,
			LIB.po,
			LIB.referencia,
			LIB.unidad,
			LIB.saldo,
			LIB.sli_total
	FROM	libroexistencias LIB INNER JOIN #tmp_id TMP ON LIB.id = TMP.id
	WHERE	LIB.saldo > 0
	*/

	OPEN	LibroCompras

	FETCH	NEXT FROM LibroCompras
	INTO	@id,
			@articulo,
			@planta,
			@docto_num,
			@docto_fec,
			@po,
			@referencia,
			@unidad,
			@saldo,
			@sli_total

	WHILE	@@FETCH_STATUS = 0
	BEGIN
		
		INSERT	INTO #tmp_1(
				articulo,
				planta,
				procedencia,
				docto_fec,
				unidad,
				saldo,
				sli_total)
		SELECT	@articulo,
				planta,
				'INI',
				docto_fec,
				unidad,
				saldo,
				costo
		FROM	#tmp_saldo_inicial
		WHERE	planta = @planta AND
				REPLACE(articulo,' ','') = REPLACE(@articulo,' ','')
		
		INSERT	INTO #tmp_1
		SELECT	id,
				articulo,
				planta,
				CASE WHEN procedencia = 'I' THEN 'INT' ELSE 'NAC' END,
				docto_num,
				docto_fec,
				po,
				referencia,
				unidad,
				cantidad,
				sli_total,
				cod_proveedor,
				proveedor,
				id_moneda
		FROM	librocompras
		WHERE	articulo = @articulo AND
				planta   = @planta
		ORDER	BY
				id
		
		INSERT	INTO #tmp_1(
				id,
				articulo,
				planta,
				procedencia,
				docto_num,
				docto_fec,
				po,
				referencia,
				unidad,
				saldo,
				sli_total,
				cod_proveedor,
				proveedor)
		SELECT	@id,
				@articulo,
				@planta,
				'FIN',
				@docto_num,
				@docto_fec,
				@po,
				@referencia,
				@unidad,
				@saldo,
				@sli_total,
				'',
				''
		
		FETCH	NEXT FROM LibroCompras
		INTO	@id,
				@articulo,
				@planta,
				@docto_num,
				@docto_fec,
				@po,
				@referencia,
				@unidad,
				@saldo,
				@sli_total
		
	END

	CLOSE		LibroCompras
	DEALLOCATE	LibroCompras

	DECLARE	@cantidad	numeric(15,4),
			@final		numeric(15,4),
			@valor		numeric(15,4),
			@ultimo		int,
			@semestral  numeric(15,4),
			@anual      numeric(15,4)

	DECLARE CorreccionMonetaria CURSOR FOR
	SELECT	num				[id],
			articulo		[Artículo],
			planta			[Planta],
			procedencia		[Procedencia],
			docto_num		[Nº Docto.],
			docto_fec		[Fecha],
			po				[PO],
			referencia		[Referencia],
			unidad			[U.M.],
			saldo			[Saldo],
			sli_total		[Costo],
			cod_proveedor	[Cod. Prov.],
			proveedor		[Proveedor],
			id_moneda		[Moneda]
	FROM	#tmp_1
	ORDER	BY
			planta,
			articulo,
			num DESC

	OPEN	CorreccionMonetaria

	FETCH	NEXT FROM CorreccionMonetaria
	INTO	@id,
			@articulo,
			@planta,
			@procedencia,
			@docto_num,
			@docto_fec,
			@po,
			@referencia,
			@unidad,
			@saldo,
			@sli_total,
			@cod_proveedor,
			@proveedor,
			@moneda

	SET		@cantidad = 0

	WHILE	@@FETCH_STATUS = 0
	BEGIN

		SELECT	@semestral = semestral,
				@anual     = anual
		FROM	par_cm_variacion
		WHERE	id_moneda = @moneda
		
		IF(@procedencia IN ('INI','FIN'))
		BEGIN
			
			SET	@cantidad = 0
			SET	@final    = @saldo
			SET	@ultimo   = 1
			
			INSERT	INTO #tmp_2(
					id,
					articulo,
					planta,
					procedencia,
					unidad,
					cantidad,
					acumulado,
					saldo,
					sli_total,
					docto_fec,
					factor,
					costo_elegido)
			SELECT	@id,
					@articulo,
					@planta,
					@procedencia,
					@unidad,
					@saldo,
					0,
					@saldo,
					@sli_total,
					@docto_fec,
					@anual,
					@sli_total
			
		END
		
		IF(@procedencia NOT IN ('INI','FIN'))
		BEGIN
			
			SET	@cantidad = @cantidad + @saldo
			
			IF(@cantidad<=@final)
			BEGIN
				INSERT	INTO #tmp_2(
						id,
						articulo,
						planta,
						procedencia,
						cod_proveedor,
						proveedor,
						docto_num,
						docto_fec,
						po,
						referencia,
						unidad,
						cantidad,
						acumulado,
						saldo,
						sli_total,
						id_moneda)
				SELECT	@id,
						@articulo,
						@planta,
						@procedencia,
						@cod_proveedor,
						@proveedor,
						@docto_num,
						@docto_fec,
						@po,
						@referencia,
						@unidad,
						@saldo,
						@cantidad,
						@cantidad,
						@sli_total,
						@moneda

				IF(@cantidad=@final)
					SET	@ultimo = 0

			END
			ELSE
			BEGIN
				
				IF(@ultimo = 1)
				BEGIN
					
					INSERT	INTO #tmp_2(
							id,
							articulo,
							planta,
							procedencia,
							cod_proveedor,
							proveedor,
							docto_num,
							docto_fec,
							po,
							referencia,
							unidad,
							cantidad,
							acumulado,
							saldo,
							sli_total,
							id_moneda)
					SELECT	@id,
							@articulo,
							@planta,
							@procedencia,
							@cod_proveedor,
							@proveedor,
							@docto_num,
							@docto_fec,
							@po,
							@referencia,
							@unidad,
							@final - (@cantidad - @saldo),
							@cantidad,
							@final - (@cantidad - @saldo),
							@sli_total,
							@moneda
					
					SET	@ultimo = 0
					
				END
				
			END
			
		END
		
		FETCH	NEXT FROM CorreccionMonetaria
		INTO	@id,
				@articulo,
				@planta,
				@procedencia,
				@docto_num,
				@docto_fec,
				@po,
				@referencia,
				@unidad,
				@saldo,
				@sli_total,
				@cod_proveedor,
				@proveedor,
				@moneda
		
	END

	CLOSE		CorreccionMonetaria
	DEALLOCATE	CorreccionMonetaria

	SELECT	articulo,
			planta,
			MAX(id) id
	INTO	#tmp_elegido_1
	FROM	#tmp_2
	WHERE	procedencia NOT IN ('INI','FIN')
	GROUP	BY
			articulo,
			planta

	SELECT	TM1.articulo,
			TM1.planta,
			TM1.docto_fec,
			TM1.sli_total
	INTO	#tmp_elegido_2
	FROM	#tmp_2 TM1 INNER JOIN #tmp_elegido_1 TM2 ON TM1.id = TM2.id

	SELECT	TM1.id								[ID],
			TM1.articulo						[Artículo],
			TM1.planta							[Planta],
			TM1.procedencia						[Procedencia],
			TM1.id_moneda						[Moneda],
			TM1.docto_num						[Nº Docto.],
			CONVERT(CHAR(10),TM1.docto_fec,103)	[Fecha],
			TM1.po								[PO],
			TM1.referencia						[Referencia],
			TM1.unidad							[U.M.],
			TM1.cantidad						[Saldo/Cant.],
			TM1.sli_total						[Costo<br>&nbsp;Aduanero],
			TM1.sli_total*TM1.saldo				[Costo<br>&nbsp;Directo],
			CASE WHEN TM2.sli_total IS NULL THEN TM1.costo_elegido ELSE TM2.sli_total END				[Costo<br>&nbsp;Elegido],
			(CASE WHEN TM2.sli_total IS NULL THEN TM1.costo_elegido ELSE TM2.sli_total END)*TM1.saldo	[Costo total<br>&nbsp;Elegido],
			CASE WHEN TM2.docto_fec IS NOT NULL THEN CASE WHEN TM2.docto_fec < '20060701' THEN PAR.semestral ELSE 1 END ELSE TM1.factor END [Factor<br>&nbsp;Corrección],
			0 [OBS]
	INTO	#tmp_correccion
	FROM	#tmp_2 TM1 LEFT OUTER JOIN #tmp_elegido_2   TM2 ON TM1.planta = TM2.planta AND TM1.articulo = TM2.articulo
					   LEFT OUTER JOIN par_cm_variacion PAR ON TM1.id_moneda = PAR.id_moneda
	ORDER	BY
			TM1.planta,
			TM1.articulo,
			TM1.id

	/* Eliminación de saldos iniciales sobrantes */

	SELECT	[Planta]			planta,
			[Artículo]			articulo,
			SUM([Saldo/Cant.])	saldo
	INTO	#tmp_suma_001
	FROM	#tmp_correccion
	WHERE	procedencia NOT IN ('INI','FIN')
	GROUP	BY
			[Planta],
			[Artículo]

	SELECT	[Planta]			planta,
			[Artículo]			articulo,
			SUM([Saldo/Cant.])	saldo
	INTO	#tmp_suma_002
	FROM	#tmp_correccion
	WHERE	procedencia IN ('FIN')
	GROUP	BY
			[Planta],
			[Artículo]

	UPDATE	#tmp_correccion
	SET		#tmp_correccion.[OBS] = -1
	FROM	#tmp_correccion COR INNER JOIN #tmp_suma_001 TM1 INNER JOIN #tmp_suma_002 TM2 ON TM1.planta = TM2.planta AND TM1.articulo = TM2.articulo ON COR.planta = TM1.planta AND COR.[Artículo] = TM1.articulo
	WHERE	TM1.saldo = TM2.saldo

	DELETE	FROM #tmp_correccion
	WHERE	[OBS] = -1 AND
			[Procedencia] = 'INI'

	UPDATE	#tmp_correccion
	SET		#tmp_correccion.[OBS] = TM2.saldo - TM1.saldo
	FROM	#tmp_correccion COR INNER JOIN #tmp_suma_001 TM1 INNER JOIN #tmp_suma_002 TM2 ON TM1.planta = TM2.planta AND TM1.articulo = TM2.articulo ON COR.planta = TM1.planta AND COR.[Artículo] = TM1.articulo
	WHERE	TM1.saldo <> TM2.saldo

	UPDATE	#tmp_correccion
	SET		[Saldo/Cant.] = [OBS]
	WHERE	[Procedencia] = 'INI' AND
			[OBS] <> 0

	/* Modificación de saldos iniciales sobrantes */

	SELECT	[Planta]			planta,
			[Artículo]			articulo,
			SUM([Saldo/Cant.])	saldo
	INTO	#tmp_suma_003
	FROM	#tmp_correccion
	WHERE	procedencia IN ('INI')
	GROUP	BY
			[Planta],
			[Artículo]

	UPDATE	#tmp_correccion
	SET		[OBS] = 0

	UPDATE	#tmp_correccion
	SET		#tmp_correccion.[OBS] = TM2.saldo
	FROM	#tmp_correccion TMP INNER JOIN
			(#tmp_suma_003  TM1 INNER JOIN      #tmp_suma_002 TM2 ON TM1.planta = TM2.planta AND TM1.articulo = TM2.articulo
								LEFT OUTER JOIN #tmp_suma_001 TM3 ON TM1.planta = TM3.planta AND TM1.articulo = TM3.articulo) ON TMP.[Planta] = TM1.planta AND TMP.[Artículo] = TM1.articulo
	WHERE	TM1.saldo > TM2.saldo AND
			TM3.articulo IS NULL

	UPDATE	#tmp_correccion
	SET		[Saldo/Cant.] = [OBS]
	WHERE	[Procedencia] = 'INI' AND
			[OBS] <> 0

	DELETE	FROM CorreccionMonetaria

	INSERT	INTO CorreccionMonetaria(
			[Artículo],
			[Planta],
			[Procedencia],
			[Moneda],
			[Nº Docto.],
			[Fecha],
			[PO],
			[Referencia],
			[U.M.],
			[Saldo/Cant.],
			[Costo<br>&nbsp;Aduanero],
			[Costo<br>&nbsp;Directo],
			[Costo<br>&nbsp;Elegido],
			[Costo total<br>&nbsp;Elegido],
			[Factor<br>&nbsp;Corrección],
			[Costo<br>&nbsp;Reposición],
			[Corrección<br>&nbsp;Monetaria])
	SELECT	[Artículo],
			[Planta],
			[Procedencia],
			[Moneda],
			[Nº Docto.],
			[Fecha],
			[PO],
			[Referencia],
			[U.M.],
			[Saldo/Cant.],
			[Costo<br>&nbsp;Aduanero],
			[Costo<br>&nbsp;Aduanero]*[Saldo/Cant.],
			[Costo<br>&nbsp;Elegido],
			[Costo<br>&nbsp;Elegido]*[Saldo/Cant.],
			(CASE WHEN ISNULL([Factor<br>&nbsp;Corrección],0) = 0 THEN 1 ELSE [Factor<br>&nbsp;Corrección] END)																				[Factor<br>&nbsp;Corrección],
			(CASE WHEN ISNULL([Factor<br>&nbsp;Corrección],0) = 0 THEN 1 ELSE [Factor<br>&nbsp;Corrección] END) * ([Costo<br>&nbsp;Elegido]*[Saldo/Cant.])									[Costo<br>&nbsp;Reposición],
			(CASE WHEN ISNULL([Factor<br>&nbsp;Corrección],0) = 0 THEN 1 ELSE [Factor<br>&nbsp;Corrección] END) * (([Costo<br>&nbsp;Elegido] - [Costo<br>&nbsp;Aduanero])*[Saldo/Cant.])	[Corrección<br>&nbsp;Monetaria]
	FROM	#tmp_correccion
	ORDER	BY
			[Planta],
			[Artículo],
			[ID]

	-- spCorreccionMonetaria @Ano = 2006

	DROP	TABLE #tmp_id
	DROP	TABLE #tmp_saldo_inicial
	DROP	TABLE #tmp_libroexistencias
	DROP	TABLE #tmp_libroexistencias_001

	DROP	TABLE #tmp_elegido_1
	DROP	TABLE #tmp_elegido_2

	DROP	TABLE #tmp_1
	DROP	TABLE #tmp_2

	DROP	TABLE #tmp_suma_001
	DROP	TABLE #tmp_suma_002

	DROP	TABLE #tmp_correccion

END
ELSE
BEGIN
	
	SELECT	[Planta],
			[Artículo],
			SUM([Saldo/Cant.])						[Saldo/Cant.],
			SUM([Costo<br>&nbsp;Directo])			[Costo<br>&nbsp;Directo],
			SUM([Costo total<br>&nbsp;Elegido])		[Costo total<br>&nbsp;Elegido],
			SUM([Costo<br>&nbsp;Reposición])		[Costo<br>&nbsp;Reposición],
			SUM([Corrección<br>&nbsp;Monetaria])	[Corrección<br>&nbsp;Monetaria]
	FROM	correccionmonetaria
	WHERE	[Artículo] = @Art AND
			[Planta]   = @Pla AND
			[Procedencia] IN ('INT','NAC')
	GROUP	BY
			[Planta],
			[Artículo]
	
END

GO


