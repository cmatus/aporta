<%@ Page Language="VB" Debug ="true" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<%@ Import Namespace="System.Data.SqlClient" %>

<script language="JScript">
    function DoScroll(){
        document.all("DataGrid1").style.pixelLeft = MyDataGridDet.scrollLeft * -1;
    }
</script>
<script runat="server">
    
    Dim oDs As New DataSet()
    dim a1,a2 as Integer
    
    Private Sub Page_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load 
        
        Dim Conn As SqlConnection = Nothing
        Dim ConnStr As String = ConfigurationManager.ConnectionStrings("Comex").ToString()
        Conn = New SqlConnection(ConnStr)
        Dim dsGrid As New DataSet
        Dim lsSql As String = "spFacturasFaltantes"
        Dim sqlDA As New SqlDataAdapter(lsSql, Conn)
        sqlDA.Fill(dsGrid, "DS")
        DataGrid2.DataSource = dsGrid
        DataGrid2.DataBind()
        DataGrid1.DataSource = dsGrid
        DataGrid1.DataBind()
        DataGrid3.DataSource = dsGrid
        DataGrid3.DataBind


    
    End Sub
    
    Private Sub ButtonClick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles boton1.Click
        
        ' Damos la salida como attachment con el nombre de Testeo.xls.
        a1 = 0
        a2 = 0
        
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
    
    Sub Header_Created(sender As Object, e As DataGridItemEventArgs)
        
    	e.item.Cells(0).Width = Unit.Pixel(41)
    	e.item.Cells(1).Width = Unit.Pixel(100)
    	e.item.Cells(2).Width = Unit.Pixel(50)
    	e.item.Cells(3).Width = Unit.Pixel(70)
    	e.item.Cells(4).Width = Unit.Pixel(40)
      	e.item.Cells(5).Width = Unit.Pixel(70)
    	e.item.Cells(6).Width = Unit.Pixel(80)
    	e.item.Cells(7).Width = Unit.Pixel(80)
    	e.item.Cells(8).Width = Unit.Pixel(70)
    	e.item.Cells(9).Width = Unit.Pixel(100)
    	e.item.Cells(10).Width = Unit.Pixel(60)
    	e.item.Cells(11).Width = Unit.Pixel(220)
    	e.item.Cells(12).Width = Unit.Pixel(80)
    	e.item.Cells(13).Width = Unit.Pixel(220)
		
		dim x as Integer = 1
		for x= 1 to 13
		e.item.Cells(x).Font.Bold = true
		e.item.Cells(x).HorizontalAlign = HorizontalAlign.Center
		next
    	e.item.Cells(0).HorizontalAlign = HorizontalAlign.right
    
    End Sub 
    
    Sub Item_Created(sender As Object, e As DataGridItemEventArgs)
        
    	e.item.Cells(0).HorizontalAlign  = HorizontalAlign.right 
 		e.item.Cells(1).HorizontalAlign  = HorizontalAlign.left
        e.item.Cells(2).HorizontalAlign  = HorizontalAlign.Center
    	e.item.Cells(3).HorizontalAlign  = HorizontalAlign.right
    	e.item.Cells(4).HorizontalAlign  = HorizontalAlign.Center
    	e.item.Cells(5).HorizontalAlign  = HorizontalAlign.Center
    	e.item.Cells(6).HorizontalAlign  = HorizontalAlign.Center
        e.item.Cells(7).HorizontalAlign  = HorizontalAlign.Center
    	e.item.Cells(8).HorizontalAlign  = HorizontalAlign.Center
    	e.item.Cells(9).HorizontalAlign  = HorizontalAlign.Center
    	e.item.Cells(10).HorizontalAlign = HorizontalAlign.Center
    	e.item.Cells(11).HorizontalAlign = HorizontalAlign.Center
    	e.item.Cells(12).HorizontalAlign = HorizontalAlign.Center
    	e.item.Cells(13).HorizontalAlign = HorizontalAlign.Center
    	
    	e.item.Cells(0).Width  = Unit.Pixel(40)
    	e.item.Cells(1).Width  = Unit.Pixel(100)
    	e.item.Cells(2).Width  = Unit.Pixel(50)
    	e.item.Cells(3).Width  = Unit.Pixel(70)
    	e.item.Cells(4).Width  = Unit.Pixel(40)
      	e.item.Cells(5).Width  = Unit.Pixel(70)
    	e.item.Cells(6).Width  = Unit.Pixel(80)
    	e.item.Cells(7).Width  = Unit.Pixel(80)
    	e.item.Cells(8).Width  = Unit.Pixel(70)
    	e.item.Cells(9).Width  = Unit.Pixel(100)
    	e.item.Cells(10).Width = Unit.Pixel(60)
    	e.item.Cells(11).Width = Unit.Pixel(220)
    	e.item.Cells(12).Width = Unit.Pixel(80)
    	e.item.Cells(13).Width = Unit.Pixel(220)
		
    End Sub

    function acum () as integer
        
        a1 = a1 + 1
        return a1
        
    end function
    function acum1 () as integer
        
        a2 = a2 + 1
        return a1
        
    end function
</script>
<html>
    <head>
        <LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
    </head>
    <body>
    <form id="Form1" method="post" runat="server">
        <div align="center">
        <div style='border-bottom:1px outset;border-top:1px inset;border-left:1px inset;border-right:1px outset;OVERFLOW: hidden; WIDTH: 950px; HEIGHT:27px; position:relative' id='DataGrid11'>
            <asp:DataGrid
                BackColor="#f3f3f3"
                style="position:relative" 
                ID="DataGrid1"
                runat="server"
                OnItemCreated="Header_Created"
                HeaderStyle-Height="27"
                Width="1280px"
                GridLines="none"
                Font-Bold="true">
                <columns>
                    <asp:TemplateColumn HeaderText="#" SortExpression="Nombre" ItemStyle-HorizontalAlign="right">
                        <HeaderStyle BackColor="#f3f3f3"></HeaderStyle>
                        <ItemTemplate>
                            <asp:Label id="Nombre" runat="server" text="<%#a1%>" BackColor="#f3f3f3"/>
                        </ItemTemplate>
                    </asp:TemplateColumn>
                </columns>
            </asp:DataGrid>
        </div>
        <div onscroll='DoScroll()' style='border-left:1px inset;border-right:1px outset;border-bottom:1px outset;OVERFLOW:auto;WIDTH:950px;HEIGHT:450px' id='MyDataGridDet'>
            <asp:DataGrid
                ForeColor="#000000"
                ID="DataGrid2"
                runat="server"
                ShowHeader="false"
                OnItemCreated="Item_Created"
                Width="1280px" >
                <AlternatingItemStyle BackColor="#f3f3f3" />
                <columns>
                    <asp:TemplateColumn HeaderText="id" SortExpression="Nombre" ItemStyle-BackColor="#f3f3f3" ItemStyle-Font-Bold="true" ItemStyle-HorizontalAlign="right">
                        <HeaderStyle BackColor="#f3f3f3" ></HeaderStyle>
                        <ItemTemplate>
                            <asp:Label id="Nombre" runat="server" text="<%#acum()%>" /> 
                        </ItemTemplate>
                    </asp:TemplateColumn>
                </columns>
				
            </asp:DataGrid>
        </div>
</div">

        <div align="center">
            
                <asp:Button Text="Exportar_Excel" ID="boton1" runat="server" ></asp:Button>
            
        </div>
        <div style="overflow:auto; width:1100px; height:200px;" align="left">
            <asp:DataGrid ForeColor="#FF0000" ID="DataGrid3" runat="server" ShowHeader="true" Font-Size="8" OnItemCreated="Item_Created" Font-Name="Italic" Visible="false" Enabled="true">
                <columns>
                    <asp:TemplateColumn HeaderText="id" SortExpression="Nombre">
                        <HeaderStyle horizontalalign="Center"></HeaderStyle>
                        <ItemTemplate>
                            <asp:Label id="Nombre" runat="server" text="<%#acum1()%>" /> 
                        </ItemTemplate>
                    </asp:TemplateColumn>
                </columns>
            </asp:DataGrid>
        </div>
       </form> 
    </body>
</html>
