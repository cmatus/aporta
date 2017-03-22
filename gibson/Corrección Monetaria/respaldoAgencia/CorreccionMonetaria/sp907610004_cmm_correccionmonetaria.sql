/****** Object:  StoredProcedure [dbo].[sp907610004_cmm_correccionmonetaria]    Script Date: 09/05/2016 13:20:39 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[sp907610004_cmm_correccionmonetaria](
	@ano    VARCHAR(4),
	@planta VARCHAR(4)
) AS

-- sp907610004_cmm_correccionmonetaria @ano = '2007', @planta = 'CL90'

DECLARE	@ano_ant VARCHAR(4)
SELECT	@ano_ant = RTRIM(LTRIM(YEAR(DATEADD(YEAR,-1,CONVERT(SMALLDATETIME,@ano + '0101',112)))))

DECLARE	@articulo VARCHAR(20),
		@procedencia VARCHAR(3),
		@moneda VARCHAR(10),
		@docto_num VARCHAR(20),
		@docto_fec SMALLDATETIME,
		@po VARCHAR(20),
		@referencia VARCHAR(20),
		@saldo NUMERIC(15,0),
		@sli_total NUMERIC(15,0),
		@semestre INT

DECLARE	@id INT,
		@procedencia_det VARCHAR(3),
		@moneda_det VARCHAR(10),
		@cantidad NUMERIC(15,0),
		@sli_total_det NUMERIC(15,0),
		@semestre_det INT

DECLARE	@acum NUMERIC(15,0),
		@articulo_ant VARCHAR(20),
		@flag INT,
		@num INT

SET	@acum = 0
SET	@articulo_ant = ''
SET	@flag = 0
SET	@num = 0

CREATE	TABLE #tmp_1(
		tipo INT NULL,
		id INT NULL,
		planta VARCHAR(4) NULL,
		articulo VARCHAR(20) NULL,
		procedencia VARCHAR(3) NULL,
		moneda VARCHAR(10) NULL,
		docto_num VARCHAR(20) NULL,
		docto_fec SMALLDATETIME NULL,
		po VARCHAR(20) NULL,
		referencia VARCHAR(20) NULL,
		saldo NUMERIC(15,0) NULL,
		sli_total NUMERIC(15,0) NULL,
		semestre INT NULL,
		cto_directo NUMERIC(15,0) NULL,
		cto_elegido NUMERIC(15,0) NULL,
		cto_reposicion NUMERIC(15,0) NULL,
		factor NUMERIC(15,9) NULL,
		revalorizado NUMERIC(15,0) NULL)

INSERT	INTO #tmp_1
SELECT	2,
		0,
		FIN.planta,
		FIN.articulo,
		CMM.procedencia,
		CMM.moneda,
		NULL,
		RTRIM(LTRIM(@ano)) + '1231',
		NULL,
		NULL,
        FIN.saldo,
		ISNULL(CONVERT(NUMERIC(15,0),CMM.elegido*CMM.factor),FIN.sli_total),
        0,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL
FROM	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_saldosiniciales]     INI ON FIN.planta = INI.planta AND FIN.articulo = INI.articulo AND INI.mes = @ano + '01'
		                                  LEFT OUTER JOIN [907610004_cmm_correccionmonetaria] CMM ON FIN.planta = CMM.planta AND FIN.articulo = CMM.articulo AND CMM.ano = @ano_ant
WHERE	FIN.mes = @ano + '12' AND
		FIN.planta = @planta AND
        ISNULL(FIN.saldo,0) <> 0
ORDER	BY
		FIN.articulo

DECLARE CMM CURSOR FOR
SELECT	planta,
		articulo,
		procedencia,
		moneda,
		saldo,
		sli_total,
		semestre
FROM	#tmp_1
ORDER	BY
		articulo
OPEN	CMM

FETCH	NEXT FROM CMM
INTO	@planta,
		@articulo,
		@procedencia,
		@moneda,
		@saldo,
		@sli_total,
		@semestre

WHILE	@@FETCH_STATUS = 0
BEGIN

	DECLARE CMM_DET CURSOR FOR
	SELECT	LIB.id,
			CASE WHEN PRO.proveedor IS NULL THEN 'INT' ELSE 'NAC' END,
			CASE WHEN PRO.proveedor IS NULL THEN CASE WHEN LIB.id_moneda = 13 THEN 'DOLAR' WHEN LIB.id_moneda = 142 THEN 'EURO' ELSE 'PESO' END ELSE 'PESO' END,
			LIB.docto_num,
			LIB.docto_fec,
			LIB.po,
			LIB.referencia,
			LIB.cantidad,
			LIB.sli_total,
			CASE WHEN MONTH(LIB.docto_fec)<=6 THEN 1 ELSE 2 END
	FROM	[907610004_cmm_libroexistencias] LIB LEFT OUTER JOIN DOCUMENTOS..proveedor_nacional PRO ON LIB.proveedor = PRO.proveedor
	WHERE	articulo = @articulo AND
			planta = @planta AND
			mov_tipo = '101' AND
			mes >= @ano + '01'
	ORDER	BY
			mes DESC,
			docto_fec DESC,
			id
	OPEN	CMM_DET

	FETCH	NEXT FROM CMM_DET
	INTO	@id,
			@procedencia_det,
			@moneda_det,
			@docto_num,
			@docto_fec,
			@po,
			@referencia,
			@cantidad,
			@sli_total_det,
			@semestre_det

	WHILE	@@FETCH_STATUS = 0
	BEGIN
		
		IF @articulo_ant<>@articulo
		BEGIN
			SET @num  = 0
			SET @acum = 0
			SET @flag = 1
		END
		SET @acum = @acum + @cantidad

		IF @flag = 1
		BEGIN
			INSERT	INTO #tmp_1
			SELECT	1,
					@id,
					@planta,
					@articulo,
					@procedencia_det,
					@moneda_det,
					@docto_num,
					@docto_fec,
					@po,
					@referencia,
					@cantidad,
					@sli_total_det,
					@semestre_det,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL
			SET @num = @num + 1
		END
		
		IF @acum >= @saldo
		BEGIN
			
			UPDATE	#tmp_1
			SET		moneda = 'DOLAR'
			WHERE	articulo = @articulo AND
					planta   = @planta   AND
					tipo     = 1         AND
					procedencia = 'INT'  AND
					moneda      = 'PESO'
			
			SELECT	@procedencia = MAX(procedencia),
					@semestre    = MAX(semestre)
			FROM	#tmp_1
			WHERE	articulo = @articulo AND
					planta   = @planta AND
					tipo     = 1
			
			IF @procedencia = 'NAC'
			BEGIN
				SELECT	@moneda     = moneda,
						@docto_num  = docto_num,
						@docto_fec  = docto_fec,
						@po         = po,
						@referencia = referencia,
						@sli_total  = sli_total
				FROM	#tmp_1
				WHERE	id IN (
						SELECT	MAX(id)
						FROM	#tmp_1
						WHERE	articulo  = @articulo AND
								planta    = @planta AND
								tipo      = 1 AND
								sli_total = (SELECT MAX(sli_total) FROM #tmp_1 WHERE articulo = @articulo AND planta = @planta))
			END
			ELSE
			BEGIN
				SELECT	@moneda     = moneda,
						@docto_num  = docto_num,
						@docto_fec  = docto_fec,
						@po         = po,
						@referencia = referencia,
						@sli_total  = sli_total
				FROM	#tmp_1
				WHERE	id IN (
						SELECT	MAX(id)
						FROM	#tmp_1
						WHERE	articulo = @articulo AND
								planta   = @planta AND
								tipo = 1)
			END

			UPDATE	#tmp_1
			SET		moneda = @moneda,
					procedencia = @procedencia,
					docto_num   = @docto_num,
					docto_fec   = @docto_fec,
					po          = @po,
					referencia  = @referencia,
					cto_elegido = @sli_total,
					semestre    = @semestre,
					id          = @num
			WHERE	articulo = @articulo AND
					planta   = @planta AND
					tipo     = 2
			SET		@flag = 0
		END
		SET @articulo_ant = @articulo
		
		FETCH	NEXT FROM CMM_DET
		INTO	@id,
				@procedencia_det,
				@moneda_det,
				@docto_num,
				@docto_fec,
				@po,
				@referencia,
				@cantidad,
				@sli_total_det,
				@semestre_det
		
	END

	CLOSE		CMM_DET
	DEALLOCATE	CMM_DET
	
	FETCH	NEXT FROM CMM
	INTO	@planta,
			@articulo,
			@procedencia,
			@moneda,
			@saldo,
			@sli_total,
			@semestre
	
END

UPDATE	#tmp_1
SET		procedencia = 'NAC',
		moneda = 'PESO'
WHERE	tipo   = 2 AND
		moneda IS NULL

SELECT	TMP.id,
		TMP.tipo,
		TMP.planta,
		TMP.articulo,
		TMP.procedencia,
		TMP.moneda,
		TMP.docto_num,
		TMP.docto_fec,
		TMP.po,
		TMP.referencia,
		TMP.saldo,
		TMP.sli_total,
		TMP.sli_total*TMP.saldo cto_directo,
		TMP.cto_elegido,
		TMP.cto_elegido*TMP.saldo cto_reposicion,
		CASE WHEN TMP.semestre=1 THEN VAR.primero WHEN TMP.semestre=2 THEN VAR.segundo ELSE VAR.anual END factor,
		CONVERT(NUMERIC(15,0),TMP.cto_elegido*CASE WHEN TMP.semestre=1 THEN VAR.primero WHEN TMP.semestre=2 THEN VAR.segundo ELSE VAR.anual END) cto_reval,
		CONVERT(NUMERIC(15,0),TMP.cto_elegido*CASE WHEN TMP.semestre=1 THEN VAR.primero WHEN TMP.semestre=2 THEN VAR.segundo ELSE VAR.anual END)*TMP.saldo cto_reval_tot,
		(CONVERT(NUMERIC(15,0),TMP.cto_elegido*CASE WHEN TMP.semestre=1 THEN VAR.primero WHEN TMP.semestre=2 THEN VAR.segundo ELSE VAR.anual END)-TMP.cto_elegido)*TMP.saldo correccion,
		TMP.semestre
INTO	#tmp_2
FROM	#tmp_1 TMP LEFT OUTER JOIN [907610004_cmm_variacionporcentual] VAR ON CASE WHEN TMP.moneda = 'DOLAR' THEN 13 WHEN TMP.moneda = 'EURO' THEN 142 ELSE 0 END = VAR.id_moneda AND VAR.ano = @ano
ORDER	BY
		TMP.planta,
		TMP.articulo,
		TMP.tipo,
		TMP.docto_fec

UPDATE	#tmp_2
SET		cto_elegido    = sli_total,
		cto_reposicion = cto_directo,
		cto_reval      = CONVERT(NUMERIC(15,0),sli_total * factor),
		cto_reval_tot  = CONVERT(NUMERIC(15,0),sli_total * factor) * saldo,
		correccion     = (CONVERT(NUMERIC(15,0),sli_total * factor) - sli_total) * saldo
WHERE	id = 0

DELETE	FROM [907610004_cmm_correccionmonetaria]
WHERE	planta = @planta AND
		ano    = @ano

INSERT  INTO [907610004_cmm_correccionmonetaria](       
        ano,
        planta,
        articulo,
        procedencia,
        moneda,
        docto_num,
        docto_fec,
        po,
        referencia,
        saldo,
        sli_total,
        elegido,
        factor,
        correccion,
        semestre)
SELECT	@ano,
        @planta,
        articulo,
        procedencia,
        moneda,
        docto_num,
        docto_fec,
        po,
        referencia,
        saldo,
        sli_total,
        cto_elegido,
        factor,
        correccion,
        semestre
FROM	#tmp_2
WHERE	tipo = 2

SELECT	*
FROM	#tmp_2

DROP TABLE #tmp_1
DROP TABLE #tmp_2

CLOSE		CMM
DEALLOCATE	CMM

GO


