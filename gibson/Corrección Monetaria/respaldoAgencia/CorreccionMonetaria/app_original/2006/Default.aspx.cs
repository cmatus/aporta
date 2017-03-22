using iTextSharp.text;
using iTextSharp.text.pdf;
using iTextSharp.text.pdf.collection;
using System;
using System.IO;
using System.Data;
using System.Data.SqlClient;
using System.Configuration;
using System.Web;
using System.Web.Security;
using System.util;
using System.Collections;




public partial class _Default : System.Web.UI.Page 
{
    int rows=0;
    int cols=0;
    int pag = 0;
    int inscolum = 100;
    int numArt = 0;
    DataTable dt;
    String[,] registro     = new String [10000,300];
    protected void Page_Load(object sender, EventArgs e)
    {
        Console.WriteLine("LALALA"); 
    }
    public void sp()
    {
        String strConnString = ConfigurationManager.ConnectionStrings["Conexion"].ToString();
        SqlConnection conn = new SqlConnection(strConnString);
        dt = new DataTable();
        SqlDataAdapter da = new SqlDataAdapter("spLibroExistencias", conn);
        da.SelectCommand.CommandType = CommandType.StoredProcedure;
        da.SelectCommand.Parameters.Add("@Planta", SqlDbType.VarChar,25);
        da.SelectCommand.Parameters["@Planta"].Value = txtPla.Text;
        da.SelectCommand.Parameters.Add("@Mes", SqlDbType.VarChar, 6);
        da.SelectCommand.Parameters["@Mes"].Value = txtFec.Text;
        da.Fill(dt);
        rows = dt.Rows.Count;
        cols = dt.Columns.Count;
        mostrar();
        //dr = dt.Rows[n];    para buscar una fila
        //dr[m].ToString();   para  agregar las columnas
    }
    public void mostrar()
    {
        Console.WriteLine("Chapter 5 example 1: my first table");
        float ejeX = (((float)21.5 / (float)2.54) * (float)72);
        float ejeY = (((float)33 / (float)2.54) * (float)72);
        float borT = (((float)3 / (float)2.54) * (float)72);
        float borB = (((float)0.5 / (float)2.54) * (float)72);
        float borL = (((float)1 / (float)2.54) * (float)72);
        float borR = (((float)1 / (float)2.54) * (float)72);
        Rectangle OFICIO = new Rectangle(ejeY, ejeX);
        // step 1: creation of a document-object
        Document document = new Document();
        try
        {
            Response.Write(txtFec.Text.Substring(4, 2));
            String mes = "";

            if ((txtFec.Text.Substring(4, 2)).Equals("03"))
            {
                mes = "Marzo";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("04"))
            {
                mes = "Abril";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("05"))
            {
                mes = "Mayo";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("06"))
            {
                mes = "Junio";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("07"))
            {
                mes = "Julio";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("08"))
            {
                mes = "Agosto";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("09"))
            {
                mes = "Septiembre";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("10"))
            {
                mes = "Octubre";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("11"))
            {
                mes = "Noviembre";
            }
            else if ((txtFec.Text.Substring(4, 2)).Equals("12"))
            {
                mes = "Diciembre";
            }
            document.SetPageSize(OFICIO);
            document.SetMargins(borL, borR, borT, borB);
            // step 2: we create a writer that listens to the document
            PdfWriter.GetInstance(document, new FileStream(Server.MapPath("Reporte.pdf"), FileMode.Create));
            // step 3: we open the document
            document.AddTitle("Libro de Existencia");
            document.AddSubject("Libro de Existencia");
            document.AddKeywords("Libro de Existencia");
            document.AddCreator("Ernesto");
            document.AddHeader("Libro de Existencia", "Libro de Existencia");
            HeaderFooter footer = new HeaderFooter(new Phrase("Pagina: "), true);
            footer.Border = Rectangle.NO_BORDER;
            document.Footer = footer;
            HeaderFooter header = new HeaderFooter(new Phrase("Libro Existencia\n " +txtPla.Text +"\n " + mes+" "+txtFec.Text.Substring(0, 4)), false);
            header.Bottom = 1;
            header.SetAlignment("CENTER");
            header.Border = 0;
            header.Alignment = Element.ALIGN_CENTER;
            document.Header = header;
            // we trigger a page break
            document.Open();
            // step 4: we add content to the document (this happens in a seperate method)
            loadDocument(document);
        }
        catch (Exception e2)
        {
            Console.WriteLine(e2);
            Response.Write("hola1 malo");
        }
        // step 5: we close the document
        document.Close();
        Response.Redirect("Reporte.pdf");
    }
    protected void Ver_Click(object sender, EventArgs e)
    {
        sp();
    }
    public void loadDocument(Document document)
    {
        Console.WriteLine("Escribiendo una línea en la consola"); 
        int NumColumns = 17;
        try
        {
            PdfPTable datatable = new PdfPTable(NumColumns);
            datatable.DefaultCell.Padding = 2;
            float[] headerwidths = { 10,  5, 5, 5, 5, 8, 5, 4, 4, 5, 13,3,6,6,8,13,6 }; // percentage
            datatable.SetWidths(headerwidths);
            datatable.WidthPercentage = 100;
            // percentage
            datatable.DefaultCell.BorderWidth = 1;
            datatable.DefaultCell.GrayFill = 0.9f;
            datatable.DefaultCell.HorizontalAlignment = Element.ALIGN_CENTER;
            for (int x = 0; x < 17; x++)
            {
                datatable.AddCell(new Phrase(dt.Columns[x].ToString(), FontFactory.GetFont(FontFactory.COURIER, 6)));
            }
            datatable.HeaderRows = 1;  // this is the end of the table header
            datatable.DefaultCell.BorderWidth = 1;
            DataRow dr;
            DataRow dr2 = null;
            int max = rows;
            dr = dt.Rows[0];
            String comArt = dr[0].ToString();
            int cont=0;
            Boolean verf = false;
            String[] reg = new String[100000];
            float[] cant = new float[100000];
            String[] des = new String[100000];
            for (int i = 0; i < rows; i++)
            {
                verf = false;
                dr = dt.Rows[i];
                PdfPCell cell = null;
                
                for (int x = 0; x < 17; x++)
                {
                    cell = new PdfPCell(new Phrase(dr[x].ToString(), FontFactory.GetFont(FontFactory.HELVETICA, 6)));
                    if (x == 2 || x == 3 || x == 5 || x == 7 || x == 8 || x == 16)
                    {
                        cell.HorizontalAlignment = Element.ALIGN_RIGHT;
                    }
                    else
                    {
                        cell.HorizontalAlignment = Element.ALIGN_LEFT;
                    }
                    datatable.AddCell(cell);
                }
                for (int x = 0; x < cont; x++)
                {
                    if ((dr[9].ToString()).Equals(reg[x]))
                    {
                        if (reg[x].Equals("999") || reg[x].Equals("000"))
                        {
                            verf = true;
                            cant[x] = cant[x] + float.Parse(dr[3].ToString());
                        }
                        else
                        {
                            verf = true;
                            cant[x] = cant[x] + float.Parse(dr[2].ToString());
                        }
                        
                    }
                }
                if (verf == false)
                {
                    reg[cont] = dr[9].ToString();
                    if (dr[9].ToString().Equals("999") || dr[9].ToString().Equals("000"))
                    {
                        cant[cont] = float.Parse(dr[3].ToString());
                    }
                    else
                    {
                        cant[cont] = float.Parse(dr[2].ToString());
                    }
                    des[cont] = dr[10].ToString();
                    cont = cont + 1;
                }
                if (rows != (i + 1))
                {
                    dr2 = dt.Rows[i + 1];
                }
                if (rows == (i + 1) || (!comArt.Equals(dr2[0].ToString())))
                {
                    comArt = dr2[0].ToString();
                    for (int c = 0; c < cont; c++)
                    {
                        PdfPCell cell3 = null;

                        cell3 = new PdfPCell(new Phrase(des[c], FontFactory.GetFont(FontFactory.HELVETICA, 6, Font.BOLD)));
                        cell3.Colspan = 8;
                        cell3.HorizontalAlignment = Element.ALIGN_RIGHT;
                        cell3.Border = 0;
                        datatable.AddCell(cell3);
                        cell3 = new PdfPCell(new Phrase("", FontFactory.GetFont(FontFactory.HELVETICA, 6, Font.BOLD)));
                        cell3.HorizontalAlignment = Element.ALIGN_LEFT;
                        cell3.Border = 0;
                        datatable.AddCell(cell3);
                        cell3 = new PdfPCell(new Phrase(reg[c].ToString(), FontFactory.GetFont(FontFactory.HELVETICA, 6, Font.BOLD)));
                        cell3.HorizontalAlignment = Element.ALIGN_LEFT;
                        cell3.Border = 0;
                        datatable.AddCell(cell3);
                        cell3 = new PdfPCell(new Phrase(cant[c].ToString(), FontFactory.GetFont(FontFactory.HELVETICA, 6, Font.BOLD)));
                        cell3.Colspan = 7;
                        cell3.HorizontalAlignment = Element.ALIGN_LEFT;
                        cell3.Border = 0;
                        datatable.AddCell(cell3);
                    }
                    cont = 0;
                }
            }
            document.Add(datatable);
        }
        catch (Exception e)
        {
            Console.Error.WriteLine(e.StackTrace);
        }
    }
}