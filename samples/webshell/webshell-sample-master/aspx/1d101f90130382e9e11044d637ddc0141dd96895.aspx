<%@ Page Language="C#" Debug="false" %>
<%@ import Namespace="System.Data"%>
<%@ import Namespace="System.Data.OleDb"%>
<%@ import Namespace="System.Data.Common"%>
<%@ Import Namespace="System.Data.SqlClient"%>
<script runat="server">
protected void Page_Load(object sender,EventArgs e)
{
    Response.Buffer = true;
        Server.ScriptTimeout = 2147483647;
    
    string sConnStr = "Driver={Sql Server};Server=192.168.1.5;Uid=mssql用户名;Pwd=mssql密码;Database=库名"; //这里是连接字符串
    string sSQL = "SELECT * FROM [库名].dbo.[表名]";  //这里是导哪个库哪个表的语句，可以写多条语句，用半角分号隔开
    
    DataSet ds = Query(sSQL, sConnStr);
    
    if(ds.Tables.Count < 1)
    {
        Response.Write("返回结果为空。");
    }
    else
    {
        for (int i = 0; i < ds.Tables.Count; i++ )
        {
            DataTable dt = ds.Tables[i];
            
            //输出表名
            Response.Write(dt.TableName + "\r\n");
            //输出字段名
            for(int j = 0; j < dt.Columns.Count; j++)
            {
                Response.Write(dt.Columns[j].ColumnName + "\t");
            }
            Response.Write("\r\n");
            
            //输出数据行
            for (int j = 0; j < dt.Rows.Count; j++)
            {
                if (j % 100 == 0) Response.Flush();

                for (int k = 0; k < dt.Columns.Count; k++)
                {
                    Response.Write(dt.Rows[j][k] + "\t");
                }
                Response.Write("\r\n");
            }
        }
    }
}

/// <summary>
/// 执行查询语句，返回DataSet
/// </summary>
/// <param name="SQL">查询语句</param>
/// <param name="ConnStr">连接字符串</param>
/// <returns>DataSet</returns>
public static DataSet Query(string SQL, string ConnStr)
{
    using (SqlConnection connection = new SqlConnection(ConnStr))
    {
        DataSet ds = new DataSet();
        try
        {
            connection.Open();
            SqlDataAdapter command = new SqlDataAdapter(SQL, connection);
            command.Fill(ds, "ds");
        }
        catch (System.Data.SqlClient.SqlException ex)
        {
            throw new Exception(ex.Message);
        }
        return ds;
    }
}
</script>