<?php
	
    $dbh = mssql_connect("jupiter","sis_sli","sliusr") or die ('I cannot connect to the database because: ' . mssql_error());
    mssql_select_db("personalizados");
	
	$handle = fopen("libroexistencias.sql","w");
	
	$lsSQL = "
	SELECT  id,
            mes,
            jerarquia,
            articulo,
            planta,
            bodega,
            isnull(cantidad,0) cantidad,
            unidad,
            isnull(valor,0) valor,
            moneda,
            isnull(costo,0) costo,
            mov_tipo,
            mov_desc,
            mov_reg,
            docto_num,
            convert(char(8),docto_fec,112) docto_fec,
            referencia,
            proveedor,
            descripcion,
            po,
            cod_proveedor,
            isnull(Sli_Total_Factura,0) Sli_Total_Factura,
            isnull(Sli_Desembolsos,0) Sli_Desembolsos,
            isnull(Sli_Flete_Interno,0) Sli_Flete_Interno,
            isnull(Sli_Gtos_Despacho,0) Sli_Gtos_Despacho,
            isnull(Sli_Otros_Gastos,0) Sli_Otros_Gastos,
            isnull(Sli_Honorarios,0) Sli_Honorarios,
            isnull(Sli_FOB,0) Sli_FOB,
            isnull(Sli_Flete,0) Sli_Flete,
            isnull(Sli_Seguro,0) Sli_Seguro,
            isnull(saldo,0) saldo,
            isnull(ppp,0) ppp,
            isnull(Sli_Total,0) Sli_Total,
            Embarque,
            Despacho,
            id_moneda,
            Num_Factura,
            isnull(tipo_cambio,0) tipo_cambio,
            convert(char(8),fecha_pago,112) docto_fec,
            isnull(valor_factura_mon,0) valor_factura_mon,
            isnull(ppp_acumulado,0) ppp_acumulado
    FROM    [907610004_cmm_libroexistencias]";
    $result = mssql_query($lsSQL);
    while($row = mssql_fetch_array($result)){
        $lsINS = "INSERT  INTO [907610004_cmm_borrar](id,mes,jerarquia,articulo,planta,bodega,cantidad,unidad,valor,moneda,costo,mov_tipo,mov_desc,mov_reg,docto_num,docto_fec,referencia,proveedor,descripcion,po,cod_proveedor,Sli_Total_Factura,Sli_Desembolsos,Sli_Flete_Interno,Sli_Gtos_Despacho,Sli_Otros_Gastos,Sli_Honorarios,Sli_FOB,Sli_Flete,Sli_Seguro,saldo,ppp,Sli_Total,Embarque,Despacho,id_moneda,Num_Factura,tipo_cambio,fecha_pago,valor_factura_mon,ppp_acumulado) VALUES(".trim($row["id"]).",'".trim($row["mes"])."','".trim($row["jerarquia"])."','".trim($row["articulo"])."','".trim($row["planta"])."','".trim($row["bodega"])."',".trim($row["cantidad"]).",'".trim($row["unidad"])."',".trim($row["valor"]).",'".trim($row["moneda"])."',".trim($row["costo"]).",'".trim($row["mov_tipo"])."','".trim($row["mov_desc"])."','".trim($row["mov_reg"])."','".trim($row["docto_num"])."','".trim($row["docto_fec"])."','".trim($row["referencia"])."','".trim($row["proveedor"])."','".trim($row["descripcion"])."','".trim($row["po"])."','".trim($row["cod_proveedor"])."',".trim($row["Sli_Total_Factura"]).",".trim($row["Sli_Desembolsos"]).",".trim($row["Sli_Flete_Interno"]).",".trim($row["Sli_Gtos_Despacho"]).",".trim($row["Sli_Otros_Gastos"]).",".trim($row["Sli_Honorarios"]).",".trim($row["Sli_FOB"]).",".trim($row["Sli_Flete"]).",".trim($row["Sli_Seguro"]).",".trim($row["saldo"]).",".trim($row["ppp"]).",".trim($row["Sli_Total"]).",'".trim($row["Embarque"])."','".trim($row["Despacho"])."','".trim($row["id_moneda"])."','".trim($row["Num_Factura"])."',".trim($row["tipo_cambio"]).",'".trim($row["fecha_pago"])."',".trim($row["valor_factura_mon"]).",".trim($row["ppp_acumulado"]).");\n";
        fwrite($handle,$lsINS);
    }
    fclose($handle);
	
?>
