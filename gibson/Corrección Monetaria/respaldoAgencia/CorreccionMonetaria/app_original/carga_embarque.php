<?php
    
    include("conexion.php");
    
    $lsSQL = "select id,mes,jerarquia,articulo,planta,bodega,cantidad,unidad,valor,moneda,costo,mov_tipo,mov_desc,mov_reg,docto_num,docto_fec,referencia,proveedor,descripcion,po,cod_proveedor,Sli_Total_Factura,Sli_Desembolsos,Sli_Flete_Interno,Sli_Gtos_Despacho,Sli_Otros_Gastos,Sli_Honorarios,Sli_FOB,Sli_Flete,Sli_Seguro,Sli_Total,Embarque,Despacho,id_moneda,Num_Factura from [907610004_cmm_libroexistencias] where planta = 'CL11' and mes = '200704' order by mes,jerarquia,articulo,planta,bodega,cantidad,unidad,valor,moneda,costo,mov_tipo,mov_desc,mov_reg,docto_num,docto_fec,referencia,proveedor,descripcion,po,cod_proveedor,Sli_Total_Factura,Sli_Desembolsos,Sli_Flete_Interno,Sli_Gtos_Despacho,Sli_Otros_Gastos,Sli_Honorarios,Sli_FOB,Sli_Flete,Sli_Seguro,Sli_Total,Embarque,Despacho,id_moneda,Num_Factura"; 
    $result = mssql_query($lsSQL);
    
    $lsAnt_id = "";
    $lsAnt_mes = "";
    $lsAnt_jerarquia = "";
    $lsAnt_articulo = "";
    $lsAnt_planta = "";
    $lsAnt_bodega = "";
    $lsAnt_cantidad = "";
    $lsAnt_unidad = "";
    $lsAnt_valor = "";
    $lsAnt_moneda = "";
    $lsAnt_costo = "";
    $lsAnt_mov_tipo = "";
    $lsAnt_mov_desc = "";
    $lsAnt_mov_reg = "";
    $lsAnt_docto_num = "";
    $lsAnt_docto_fec = "";
    $lsAnt_referencia = "";
    $lsAnt_proveedor = "";
    $lsAnt_descripcion = "";
    $lsAnt_po = "";
    $lsAnt_cod_proveedor = "";
    $lsAnt_Sli_Total_Factura = "";
    $lsAnt_Sli_Desembolsos = "";
    $lsAnt_Sli_Flete_Interno = "";
    $lsAnt_Sli_Gtos_Despacho = "";
    $lsAnt_Sli_Otros_Gastos = "";
    $lsAnt_Sli_Honorarios = "";
    $lsAnt_Sli_FOB = "";
    $lsAnt_Sli_Flete = "";
    $lsAnt_Sli_Seguro = "";
    $lsAnt_Sli_Total = "";
    $lsAnt_Embarque = "";
    $lsAnt_Despacho = "";
    $lsAnt_id_moneda = "";
    $lsAnt_Num_Factura = "";
    
    $liCount = 0;
    
    while($row = mssql_fetch_array($result)){
        
        if($lsAnt_mes==trim($row["mes"])&&
        $lsAnt_jerarquia==trim($row["jerarquia"])&&
        $lsAnt_articulo==trim($row["articulo"])&&
        $lsAnt_planta==trim($row["planta"])&&
        $lsAnt_bodega==trim($row["bodega"])&&
        $lsAnt_cantidad==trim($row["cantidad"])&&
        $lsAnt_unidad==trim($row["unidad"])&&
        $lsAnt_valor==trim($row["valor"])&&
        $lsAnt_moneda==trim($row["moneda"])&&
        $lsAnt_costo==trim($row["costo"])&&
        $lsAnt_mov_tipo==trim($row["mov_tipo"])&&
        $lsAnt_mov_desc==trim($row["mov_desc"])&&
        $lsAnt_mov_reg==trim($row["mov_reg"])&&
        $lsAnt_docto_num==trim($row["docto_num"])&&
        $lsAnt_docto_fec==trim($row["docto_fec"])&&
        $lsAnt_referencia==trim($row["referencia"])&&
        $lsAnt_proveedor==trim($row["proveedor"])&&
        $lsAnt_descripcion==trim($row["descripcion"])&&
        $lsAnt_po==trim($row["po"])&&
        $lsAnt_cod_proveedor==trim($row["cod_proveedor"])&&
        $lsAnt_Sli_Total_Factura==trim($row["Sli_Total_Factura"])&&
        $lsAnt_Sli_Desembolsos==trim($row["Sli_Desembolsos"])&&
        $lsAnt_Sli_Flete_Interno==trim($row["Sli_Flete_Interno"])&&
        $lsAnt_Sli_Gtos_Despacho==trim($row["Sli_Gtos_Despacho"])&&
        $lsAnt_Sli_Otros_Gastos==trim($row["Sli_Otros_Gastos"])&&
        $lsAnt_Sli_Honorarios==trim($row["Sli_Honorarios"])&&
        $lsAnt_Sli_FOB==trim($row["Sli_FOB"])&&
        $lsAnt_Sli_Flete==trim($row["Sli_Flete"])&&
        $lsAnt_Sli_Seguro==trim($row["Sli_Seguro"])&&
        $lsAnt_Sli_Total==trim($row["Sli_Total"])&&
        $lsAnt_Embarque==trim($row["Embarque"])&&
        $lsAnt_Despacho==trim($row["Despacho"])&&
        $lsAnt_id_moneda==trim($row["id_moneda"])&&
        $lsAnt_Num_Factura==trim($row["Num_Factura"])){
            $lsSQL = "DELETE FROM [907610004_cmm_libroexistencias] WHERE id = ".trim($row["id"]);
            mssql_query($lsSQL);
            $liCount++;
            echo $liCount."<br>";
        }     
        
        $lsAnt_id = trim($row["id"]);
        $lsAnt_mes = trim($row["mes"]);
        $lsAnt_jerarquia = trim($row["jerarquia"]);
        $lsAnt_articulo = trim($row["articulo"]);
        $lsAnt_planta = trim($row["planta"]);
        $lsAnt_bodega = trim($row["bodega"]);
        $lsAnt_cantidad = trim($row["cantidad"]);
        $lsAnt_unidad = trim($row["unidad"]);
        $lsAnt_valor = trim($row["valor"]);
        $lsAnt_moneda = trim($row["moneda"]);
        $lsAnt_costo = trim($row["costo"]);
        $lsAnt_mov_tipo = trim($row["mov_tipo"]);
        $lsAnt_mov_desc = trim($row["mov_desc"]);
        $lsAnt_mov_reg = trim($row["mov_reg"]);
        $lsAnt_docto_num = trim($row["docto_num"]);
        $lsAnt_docto_fec = trim($row["docto_fec"]);
        $lsAnt_referencia = trim($row["referencia"]);
        $lsAnt_proveedor = trim($row["proveedor"]);
        $lsAnt_descripcion = trim($row["descripcion"]);
        $lsAnt_po = trim($row["po"]);
        $lsAnt_cod_proveedor = trim($row["cod_proveedor"]);
        $lsAnt_Sli_Total_Factura = trim($row["Sli_Total_Factura"]);
        $lsAnt_Sli_Desembolsos = trim($row["Sli_Desembolsos"]);
        $lsAnt_Sli_Flete_Interno = trim($row["Sli_Flete_Interno"]);
        $lsAnt_Sli_Gtos_Despacho = trim($row["Sli_Gtos_Despacho"]);
        $lsAnt_Sli_Otros_Gastos = trim($row["Sli_Otros_Gastos"]);
        $lsAnt_Sli_Honorarios = trim($row["Sli_Honorarios"]);
        $lsAnt_Sli_FOB = trim($row["Sli_FOB"]);
        $lsAnt_Sli_Flete = trim($row["Sli_Flete"]);
        $lsAnt_Sli_Seguro = trim($row["Sli_Seguro"]);
        $lsAnt_Sli_Total = trim($row["Sli_Total"]);
        $lsAnt_Embarque = trim($row["Embarque"]);
        $lsAnt_Despacho = trim($row["Despacho"]);
        $lsAnt_id_moneda = trim($row["id_moneda"]);
        $lsAnt_Num_Factura = trim($row["Num_Factura"]);
        
    }
    
?>
