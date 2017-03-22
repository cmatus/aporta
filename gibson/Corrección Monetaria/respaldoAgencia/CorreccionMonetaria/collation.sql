--Latin1_General_CI_AS

select	'ALTER TABLE dbo.' + RTRIM(LTRIM(obj.name)) + ' ALTER COLUMN ' + RTRIM(LTRIM(col.name)) + ' ' + CASE WHEN typ.name = 'varchar' THEN RTRIM(LTRIM(typ.name)) + '(' + CASE WHEN COL.length = -1 THEN 'MAX' ELSE RTRIM(LTRIM(COL.length)) END + ')' ELSE RTRIM(LTRIM(typ.name)) END + ' COLLATE Latin1_General_CI_AS NULL'
from	sysobjects obj inner join syscolumns col on obj.id = col.id
		               inner join systypes typ on col.xtype = typ.xtype
where	obj.type = 'u' and
		typ.name = 'varchar'

--ALTER TABLE dbo.MyTable ALTER COLUMN CharCol  varchar(10)COLLATE Latin1_General_CI_AS NULL;

ALTER TABLE dbo.Factura_Cab ALTER COLUMN Tipo varchar(2) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Despacho varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN ID_Cliente varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Nombre_Cliente varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Direccion_Cliente varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Comuna_Cliente varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Ciudad_Cliente varchar(15) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Telefono_Cliente varchar(15) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN ID_CtaCte varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Ref_Cliente varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN ID_Ejec varchar(5) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Mercancias varchar(100) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Mercancias2 varchar(100) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Legalizacion varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Aduana varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN CEmbarque varchar(30) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Manifiesto varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Rubro varchar(1) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN TotalPalabras varchar(250) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Texto1 varchar(100) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Texto2 varchar(100) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Obs_Anulacion varchar(100) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Usuario_1 varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Usuario_2 varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN NumAceptacion varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN ID_Feria varchar(3) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Detalle varchar(150) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN DinFox varchar(1) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN sFile varchar(30) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN RutDespacho varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Detalle1 varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Detalle2 varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Detalle3 varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN DespachoAsoc varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Cod_Aduana varchar(5) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN TarHonor varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN FentregaUsr varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN TarifaHonCobrada varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN IdCiaTrans varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Obs varchar(MAX) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN NroDeclaracion varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Cab ALTER COLUMN Sistema varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Det ALTER COLUMN Tipo varchar(5) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Det ALTER COLUMN Despacho varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Det ALTER COLUMN Cod_Item varchar(5) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Det ALTER COLUMN CodAux varchar(10) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Det ALTER COLUMN Desc_Item varchar(50) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Det ALTER COLUMN Docto_Item varchar(20) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Det ALTER COLUMN Detalle varchar(255) COLLATE Latin1_General_CI_AS NULL
go
ALTER TABLE dbo.Factura_Det ALTER COLUMN TipoDoc varchar(50) COLLATE Latin1_General_CI_AS NULL
go
