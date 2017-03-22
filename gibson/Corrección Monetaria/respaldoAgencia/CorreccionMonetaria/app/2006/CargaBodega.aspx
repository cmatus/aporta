<%@ Page Language="VB" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<%@ Import Namespace="System.Data.SqlClient" %>
<script runat="server">
Dim sql1 As String
DIM coneccion AS sqlCONNECTION
Dim orden as sqlCOMMAND
dim sApartado (34) as String
Private Sub cmdEnviar_Click(ByVal sender As Object, ByVal e As System.EventArgs) _
Handles cmdEnviar.Click
try
Dim Destino As String = Server.MapPath(System.DBNull.Value.ToString()) & "\" & _ 
Path.GetFileName(File1.PostedFile.FileName)
Dim i, n, t,z As Integer
Dim oCmd As String
Dim sql As String

Dim oDa As OleDbDataAdapter
Dim dt As DataTable
coneccions()

File1.PostedFile.SaveAs(Destino)
Mensaje.Text = "Su archivo ha sido cargado en : <b>" & Destino & _
"</b><br>Tamaño: " & File1.PostedFile.ContentLength() & _
" bytes."
Destino = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=" & Destino & ";Extended Properties=Excel 8.0;"
sql= "SELECT * FROM miTabla"

oDa = New OleDbDataAdapter(sql, Destino)
dt = New DataTable
oDa.Fill(dt)
'
n = dt.Rows.Count

If n = 0 Then
    ' No se ha encontrado ningún registro que coincida con la selección

Else

    For i = 0 To n - 1
        Dim sTitulo, sLink, sDescripcion As String
        ' Asignar a las variables el contenido del registro		
		for t = 0 to 34
		sApartado(t) = ""
        sApartado(t) = dt.Rows(i)(t).ToString
        ' Mostrar los datos de la fila actual
        next
		
		sql1 = "insert into EntregaBodega (Planta,docto_num,Referencia,articulo,SLoc,MvT,usuario,descripcion,name1,mov_tipo,Item,CoCd,Time,PO,Item1,Mvt1,Cns,Rec,Vendor,MatYr,d_c,TETy,Pstg_date,Quantity_in_UnE,Doc_date,Qty_in_OPUn,OPUn,OUn,Qty_in_order_unit,Entry_date,BUn,Quantity,Curr,EUn,Amt_in_loc_cur) values (@par0,@par1,@par2,@par3,@par4,@par5,@par6,@par7,@par8,@par9,@par10,@par11,@par12,@par13,@par14,@par15,@par16,@par17,@par18,@par19,@par20,@par21,@par22,@par23,@par24,@par25,@par26,@par27,@par28,@par29,@par30,@par31,@par32,@par33,@par34)" 
orden = New SqlCommand(sql1, coneccion)
for z = 0 to 34
orden.Parameters.Add(New sqlParameter("@par"&z.tostring, sqlDbType.VarChar, 50))
orden.Parameters("@par"&z.tostring).Value = sApartado(z)
next
coneccion.Open()
orden.ExecuteNonQuery()
coneccion.close()	
     Next
End If
catch ex as Exception
response.Write(ex.ToString)
end try
actualizar()
End Sub
	public sub coneccions()
	try
	
	coneccion = New SqlConnection(ConfigurationManager.ConnectionStrings("Comex").ToString())
	
	catch e as Exception 
	response.Write(e.ToString)
	end try
	
	end sub
	
	public sub actualizar()
	try
	dim sql2 as String = "update LibroExistencia set referencia = ent.referencia, po = ent.po,descripcion = ent.descripcion, cod_proveedor = ent.vendor  from LibroExistencia per inner join EntregaBodega ent on replace(per.articulo,' ','') = ent.articulo and per.docto_num = ent.docto_num " 
	orden = New SqlCommand(sql2, coneccion)
	coneccion.Open()
	orden.ExecuteNonQuery()
	coneccion.close()
	catch ex as Exception 
	response.Write(ex.ToString)
	end try
	end sub
</script>
	
<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
    <title>Upload Files</title>
</head>
<body>
<form id="Form1" method="post" encType="multipart/form-data" runat="server">
   Seleccione el Archivo a Enviar: <INPUT id="File1" type="file" name="File1" runat="server">
     <asp:button id="cmdEnviar" runat="server" Text="Enviar"></asp:button>
     <BR>
     <asp:datagrid id="DataGrid1" runat="server" Width="585px" Height="159px" BorderColor="#E7E7FF" 
BorderStyle="None" BorderWidth="1px" BackColor="White" CellPadding="3" GridLines="Horizontal" 
Font-Names="Arial" Font-Size="10pt">
     <SelectedItemStyle Font-Bold="True" ForeColor="#F7F7F7" BackColor="#738A9C"></SelectedItemStyle>
     <AlternatingItemStyle BackColor="#F7F7F7"></AlternatingItemStyle>
     <ItemStyle ForeColor="#4A3C8C" BackColor="#E7E7FF"></ItemStyle>
     <HeaderStyle Font-Bold="True" ForeColor="#F7F7F7" BackColor="#4A3C8C"></HeaderStyle>
     <FooterStyle ForeColor="#4A3C8C" BackColor="#B5C7DE"></FooterStyle>
     <PagerStyle HorizontalAlign="Right" ForeColor="#4A3C8C" BackColor="#E7E7FF" Mode="NumericPages"></PagerStyle>
     </asp:datagrid>
     <BR>
     <asp:label id="Mensaje" runat="server"></asp:label>
</form>
</body>
</html>
