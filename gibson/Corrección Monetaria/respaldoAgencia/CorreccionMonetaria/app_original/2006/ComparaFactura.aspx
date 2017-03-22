<%@ Page Language="VB" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<%@ Import Namespace="System.Data.SqlClient" %>
<script language="JavaScript" type="text/JavaScript" 
src="http://www.stein.cl/SLI/Include/funciones.js"></script>
<script language="JScript">
var gsCelda;
var IE = document.all?true:false

if (!IE) document.captureEvents(Event.MOUSEMOVE)

document.onmousemove = getMouseXY;
var tempX = 0
var tempY = 0
function getMouseXY(e) {
  if (IE) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft
    tempY = event.clientY + document.body.scrollTop
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX
    tempY = e.pageY
  }  


  return true
}

    function DoScroll(){
        document.all("DataGrid1").style.pixelLeft = MyDataGridDet.scrollLeft * -1;
    }
	  function CargaCliente() {
       if((xmlhttp.readyState==4)){
	                   try{
                    iObj = gsCelda;
                } catch(e){
                }
                
                var xx = tempX;
                var yy = tempY;
                
                while(iObj.offsetParent){
                    if(iObj==document.getElementsByTagName('body')[0]){
                        break;
                    } else{
             	    var xx = tempX;
                	var yy = tempY;
                        iObj = iObj.offsetParent;
                    }
                }
        divDatos.style.top = yy + 20;
        divDatos.style.left = xx - 300;
        divDatos.style.width = "390px";
        divDatos.style.height = "100px";
          divDatos.innerHTML = xmlhttp.responseText;
      }
  }
  
  
</script>
<script runat="server">
Dim oDs As New DataSet()
dim a1 as Integer = 0
	Private Sub Page_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load 
		
        Dim Conn As SqlConnection = Nothing
        Dim ConnStr As String = ConfigurationManager.ConnectionStrings("Comex").ToString()
        Conn = New SqlConnection(ConnStr)
        Dim dsGrid As New DataSet
        Dim lsSql As String = "spComparaFactura"
        Dim sqlDA As New SqlDataAdapter(lsSql, Conn)
        sqlDA.Fill(dsGrid, "DS")
        DataGrid2.DataSource = dsGrid
        DataGrid2.DataBind()
        DataGrid1.DataSource = dsGrid
        DataGrid1.DataBind()
        DataGrid3.DataSource = dsGrid
        DataGrid3.DataBind()
        
       
	End Sub
	
    Sub Item_Created(sender As Object, e As DataGridItemEventArgs) 

		e.item.Cells(0).Width = Unit.Pixel(60)
		e.item.Cells(1).Width = Unit.Pixel(125)
		e.item.Cells(2).Width = Unit.Pixel(125)
		e.item.Cells(3).Width = Unit.Pixel(100)
		e.item.Cells(4).Width = Unit.Pixel(100)
		e.item.Cells(0).HorizontalAlign = HorizontalAlign.Center
		dim x as Integer = 1
				for x= 1 to 4
		
		e.item.Cells(x).HorizontalAlign = HorizontalAlign.Right
		next
		e.Item.Cells(3).Attributes.Add("onclick","javascript:gsCelda = this; GeneraObjeto('CargaCliente','factura.aspx?numfactura=' + this.document.activeElement.parentElement.childNodes(1).innerText )")
		e.Item.Cells(4).Attributes.Add("onclick","javascript:gsCelda = this; GeneraObjeto('CargaCliente','Libro.aspx?numfactura=' + this.document.activeElement.parentElement.childNodes(1).innerText )")

    End Sub 'Item_Created 
	
	Sub Header_Created(sender As Object, e As DataGridItemEventArgs) 

		e.item.Cells(0).Width = Unit.Pixel(60)
		e.item.Cells(1).Width = Unit.Pixel(125)
		e.item.Cells(2).Width = Unit.Pixel(125)
		e.item.Cells(3).Width = Unit.Pixel(100)
		e.item.Cells(4).Width = Unit.Pixel(100)
		dim x as Integer = 1
		for x= 0 to 4
		e.item.Cells(x).Font.Bold = true
		e.item.Cells(x).HorizontalAlign = HorizontalAlign.Center
		next
    End Sub 'Item_Created 
	
function acum () as integer
	a1 = a1 + 1
	return a1
end function

Private Sub ButtonClick(ByVal sender As System.Object, _
ByVal e As System.EventArgs) Handles boton1.Click
	' Damos la salida como attachment con el nombre de Testeo.xls.
	a1 = 0
	Datagrid3.Visible = true
	Response.AddHeader("content-disposition", "attachment; filename=Testeo.xls")
	' Especificamos el tipo de salida.
	Response.ContentType = "application/vnd.ms-excel"
	' Asociamos la salida con la codificación UTF7 (para poder visualizar los acentos correctamente)
	Response.ContentEncoding = System.Text.Encoding.UTF7
	Response.Charset = ""
	Me.EnableViewState = false
	Dim tw As New System.IO.StringWriter
	Dim hw As New System.Web.UI.HtmlTextWriter(tw)
	Datagrid3.RenderControl(hw)  ' g es el DATAGRID
	'Escribimos el HTML en el Explorador
	Response.Write(tw.ToString())
	' Terminamos el Response.
	Response.End()
end sub
</script>
<html>

    <head>
        <LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
    </head>
<body>

<div align="center">
  
    <div style='border-top:1px inset;border-left:1px inset;border-right:1px outset;OVERFLOW: hidden; WIDTH: 500px; HEIGHT:27px; position:relative' id='DataGrid11'>
      <asp:DataGrid  ForeColor="#000000" ID="DataGrid1" runat="server" ShowHeader="true" Font-Size="8" HeaderStyle-Height="27" OnItemCreated="Header_Created" Font-Bold="true" HorizontalAlign="Left"  HeaderStyle-BackColor="#f3f3f3" ItemStyle-Font-Bold="true">
        <columns>
        <asp:TemplateColumn HeaderText=" # " SortExpression="Nombre">
          <headerstyle HorizontalAlign="left"></headerstyle>
          <itemtemplate>
            <asp:Label ID="Nombre" runat="server" Text="<%#a1%>" ></asp:Label>    
          </itemtemplate>
        </asp:TemplateColumn>
        </columns>
      </asp:DataGrid>
	  
    </div>
	<div onscroll='DoScroll()' style='border-left:1px inset;border-right:1px outset;border-bottom:1px outset;OVERFLOW:auto;WIDTH:500px;HEIGHT:450px' id='MyDataGridDet'>
    <asp:DataGrid    ID="DataGrid2" runat="server" ShowHeader="false" Font-Size="8" OnItemCreated="Item_Created" HorizontalAlign="Left"  Font-Bold="true">
<columns>
<asp:TemplateColumn HeaderText="Nombre" SortExpression="Nombre" ItemStyle-Font-Bold="true" ItemStyle-BackColor="#f3f3f3">
 <HeaderStyle horizontalalign="left"></HeaderStyle>
  <ItemTemplate>
   <asp:Label id="Nombre" runat="server" text="<%#acum()%>" ></asp:Label> 
 </ItemTemplate>
</asp:TemplateColumn>
</columns>
</asp:DataGrid>
</div>
</div>
<div align="center">
<form name="thisform">
<div name="divDatos" id="divDatos" onClick="this.innerHTML=''" style="position:absolute;overflow:auto;width:0px;height:0px"></div>
</form>
<form runat="server">
<asp:Button Text="Exportar_Excel" ID="boton1" runat="server" ></asp:Button>
</form>
</div>

<div style="overflow:auto; width:0px; height:0px;" align="left" >
<asp:DataGrid ForeColor="#FF0000" HeaderStyle-ForeColor="#000000" ID="DataGrid3" runat="server" ShowHeader="true" Font-Size="8" OnItemCreated="Item_Created" Font-Name="Italic" Visible="false" Enabled="true" >
<columns>
<asp:TemplateColumn HeaderText="id" SortExpression="Nombre">
 <HeaderStyle horizontalalign="Center"></HeaderStyle>
  <ItemTemplate>
   <asp:Label id="Nombre" runat="server" text="<%#acum()%>" /> 
 </ItemTemplate>
</asp:TemplateColumn>
</columns>
</asp:DataGrid>
</div>
</body>
</html>
